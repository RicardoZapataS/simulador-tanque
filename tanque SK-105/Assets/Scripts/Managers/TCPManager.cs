using System;
using System.Collections.Generic;
using Newtonsoft.Json;
using UnityEngine;
using TCPSimulator;
using BeardedManStudios.Forge.Networking;
using BeardedManStudios.Forge.Networking.Unity;

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

    public bool isServer { get; set; }

    int port;
    Dictionary<int, TCPListener> OnDataReceived;
    TCPImplementation tcp;


    GameObject networkManager = null;
	NetworkManager mgr = null;
    [HideInInspector] public NetWorker netWorker;


    #region Singletone

    private static TCPManager instance = null;
    public static TCPManager Instance => instance;

    public static void CreateTCPInstance (bool isServer) {
        instance = new TCPManager(isServer);
    }

    public TCPManager(bool isServer) {
        this.isServer = isServer;
        OnDataReceived = new Dictionary<int, TCPListener>();
        string[] args = System.Environment.GetCommandLineArgs ();
        UnityEngine.Debug.Log(string.Join(" ", args));
        Console.WriteLine(string.Join(" ", args));
        if (args.Length >= 1)
            if (!int.TryParse(args[1], out port))
                port = 15940;
        else
            port = 15940;
#if !UNITY_EDITOR
        if (args.Length >= 2)
            isServer = Convert.ToBoolean(args[2]);
#endif
        // // Connect
        Debug.LogWarning("A network manager was not provided, generating a new one instead");
        networkManager = new GameObject("Network Manager");
        mgr = networkManager.AddComponent<NetworkManager>();


        //
        // Server
        //

        if (isServer) {
            netWorker = new UDPServer(64);
            ((UDPServer)netWorker).Connect("127.0.0.1", (ushort) port);
            Connected(netWorker);
        } else {
            netWorker = new UDPClient();
            ((UDPClient)netWorker).Connect("127.0.0.1", (ushort) port);
            Connected(netWorker);
        }
    }

    void Connected(NetWorker netWorker) {
		mgr.Initialize(netWorker, null, (ushort) port, null);
    }

    #endregion

    void TcpOnDataReceived(string msg) {
        Debug.Log($"Message: \"{msg}\"");
        PackerData packer = JsonConvert.DeserializeObject<PackerData>(msg);
        OnDataReceived[packer.id].callAction (packer);
    }

    public void sendData<T>(TypeDataPackage t, int id, T data) {
        // JsonConvert.SerializeObject()
        Debug.Log($"Sending \"{data.GetType().FullName}\": {data}");
        PackerData packer = new PackerData() {
            id = id,
            type = t,
            data = data
        };

        tcp.sendData(JsonConvert.SerializeObject(packer));
    }

    public void addListener(int instaceID, Action<PackerData> action) {
        if (!OnDataReceived.ContainsKey(instaceID)) {
            var l = new TCPListener();
            l.action += action;

            OnDataReceived.Add(instaceID, l);
        } else
            OnDataReceived[instaceID].action += action;
    }

    public void Disconnect() {
		NetWorker.EndSession();
		netWorker.Disconnect(true);
    }

}