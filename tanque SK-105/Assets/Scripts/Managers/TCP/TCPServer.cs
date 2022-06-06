using System;
using System.Net;
using System.Net.Sockets;
using System.Text;
using System.Threading;

namespace TCPSimulator {
    public class TCPServer : TCPImplementation {
        Thread ReadThread;

        Action<string> OnDataReceived;

        public Action OnDisconnect;
        public Action<Exception> OnError;

        #region Server Variable
        IPEndPoint ipEnd;
        Socket sock;
        Socket clientSock;
        #endregion

        public bool Connect(int port, Action<Exception> onError) {
            OnError = onError;
            try {
                ipEnd = new IPEndPoint(IPAddress.Any, port);
                sock = new Socket(AddressFamily.InterNetwork, SocketType.Stream, ProtocolType.IP);
                sock.Bind(ipEnd);
                ReadThread = new Thread(listen);
                ReadThread.Start();
                return true;
            }
            catch (Exception e) {
                OnError?.Invoke(e);
                return false;
            }
        }

        void listen() {
            sock.Listen(100);
            clientSock = sock.Accept();
            do {
                try {
                    byte[] clientData = new byte[4096];
                    clientSock.Receive(clientData);
                    string getStr = Encoding.ASCII.GetString(clientData);

                    OnDataReceived?.Invoke(getStr);
                }
                catch (Exception e) {
                    OnError?.Invoke(e);
                    break;
                }
            } while (true);

            clientSock.Close();
            sock.Close();
            OnDisconnect?.Invoke();
        }

        public void sendData(string msg) {
            try {
                if (clientSock != null)
                    clientSock.Send(Encoding.ASCII.GetBytes(msg));
            }
            catch (Exception e) {
                OnError?.Invoke(e);
            }
        }

        public void setOnDataListener(Action<string> listener) => OnDataReceived = listener;
        public void setOnDisconnect(Action listener) => OnDisconnect = listener;
        public void setOnError(Action<Exception> listener) => OnError = listener;
    }
}