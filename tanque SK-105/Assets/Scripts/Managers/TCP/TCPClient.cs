using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Net;
using System.Net.Sockets;
using System.Text;
using System.Threading;
using System.Threading.Tasks;

public class TCPClient : TCPImplementation {
    TcpClient client;
    NetworkStream Stream;
    Thread ReadThread;
    StreamWriter Writer;


    Action<string> OnDataReceived;
    public Action OnDisconnect;
    public Action<Exception> OnError;

    public bool Connect(string direccionIp, int puerto) {
        try {
            client = new TcpClient();
            client.Connect(IPAddress.Parse(direccionIp), puerto);
            Stream = client.GetStream();
            Writer = new StreamWriter(Stream);
            ReadThread = new Thread(Listen);
            ReadThread.Start();
            return true;
        }
        catch (Exception e) {
            OnError?.Invoke(e);
            return false;
        }
    }

    void Listen() {
        StreamReader reader = new StreamReader(Stream);

        do {
            try {
                if (reader == null) break;
                if (reader.EndOfStream) break;

                OnDataReceived?.Invoke(reader.ReadToEnd());
            }
            catch (Exception e) {
                OnError?.Invoke(e);
                break;
            }
        } while (true);
        OnDisconnect?.Invoke();
    }
    public void sendData(string mesaje) {
        try {
            Writer.Write(mesaje);
            Writer.Flush();
        }
        catch (Exception e) {
            OnError?.Invoke(e);
        }
    }

    public void setOnDataListener (Action<string> listener) => OnDataReceived = listener;
    public void setOnDisconnect (Action listener) => OnDisconnect = listener;
    public void setOnError (Action<Exception> listener) => OnError = listener;
}