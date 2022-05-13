using System;
using System.Collections;
using System.Collections.Generic;
using System.Diagnostics;
using System.Globalization;
using System.Linq;
using System.Runtime.InteropServices;
using Newtonsoft.Json;
using UnityEngine;

public enum TypeDataPackage {
    Instance,
    Position,
    Rotation,
    Scale
}

public class PackerData {
    public int id;
    public TypeDataPackage type;
    public object data;
}

public class TCPListener {
    public event Action<PackerData> action;

    public void callAction (PackerData packer) => action?.Invoke(packer);
}

public class TCPManager {

    public bool isServer { get; private set; }

    int port;
    Dictionary<int, TCPListener> OnDataReceived;
    TCPImplementation tcp;

    #region Singletone

    static TCPManager singletone = null;
    public static TCPManager Main => singletone;

    public static void CreateTCPInstance () {
        singletone = new TCPManager();
    }

    public TCPManager() {
        OnDataReceived = new Dictionary<int, TCPListener>();
        string[] args = System.Environment.GetCommandLineArgs ();
        UnityEngine.Debug.Log(string.Join(" ", args));
        Console.WriteLine(string.Join(" ", args));
        if (args.Length >= 1)
            if (!int.TryParse(args[1], out port))
                port = 8080;
        else
            port = 8080;
        var tryServer = new TCPServer();
        Action<Exception> onServerError = (Exception e) => {
            var client = new TCPClient();
            if (client.Connect("127.0.0.1", port)) {
                isServer = false;
                tcp = tryServer;
            } else
                throw new Exception($"No se pudo establecer coneccion con \"127.0.0.1:{port}\"");
        };

        if (tryServer.Connect(port, onServerError)) {
            tcp = tryServer;
            isServer = true;
        }

        tcp.setOnDataListener(TcpOnDataReceived);
    }

    #endregion

    void TcpOnDataReceived(string msg) {
        PackerData packer = JsonConvert.DeserializeObject<PackerData>(msg);
        OnDataReceived[packer.id].callAction (packer);
    }

    public void sendData<T>(TypeDataPackage t, int id, T data) {
        // JsonConvert.SerializeObject()
        PackerData packer = new PackerData() {
            id = id,
            type = t,
            data = data
        };

        tcp.sendData(JsonConvert.SerializeObject(data));
    }

    public void addListener(int instaceID, Action<PackerData> action) {
        if (!OnDataReceived.ContainsKey(instaceID)) {
            var l = new TCPListener();
            l.action += action;

            OnDataReceived.Add(instaceID, l);
        } else
            OnDataReceived[instaceID].action += action;
    }

}