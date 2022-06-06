using System;
using System.IO;
using System.Net;
using System.Net.Sockets;
using System.Text;
using System.Threading;

namespace TCPSimulator {
    public class TCPClient : TCPImplementation {
        Socket client;
        Thread ReadThread;


        Action<string> OnDataReceived;
        public Action OnDisconnect;
        public Action<Exception> OnError;

        public bool Connect(string direccionIp, int puerto) {
            try {
                client = new Socket(AddressFamily.InterNetwork, SocketType.Stream, ProtocolType.IP);
                client.Connect(IPAddress.Parse(direccionIp), puerto);
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
            do {
                try {
                    byte[] clientData = new byte[4096];
                    client.Receive(clientData);
                    string getStr = Encoding.ASCII.GetString(clientData);

                    OnDataReceived?.Invoke(getStr);
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
                client.Send(Encoding.ASCII.GetBytes(mesaje));
            }
            catch (Exception e) {
                OnError?.Invoke(e);
            }
        }

        public void setOnDataListener (Action<string> listener) => OnDataReceived = listener;
        public void setOnDisconnect (Action listener) => OnDisconnect = listener;
        public void setOnError (Action<Exception> listener) => OnError = listener;
    }
}