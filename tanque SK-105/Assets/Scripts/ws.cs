// unity c# code
using System.Net.Sockets;
using UnityEngine;

public class ws : MonoBehaviour
{
    private Socket socket;

    void Start()
    {
        Debug.Log("start");
        socket = System.IO.Socket("http://localhost:3000");

        socket.On(QSocket.EVENT_CONNECT, () => {
            Debug.Log("Connected");
            socket.Emit("chat", "test");
        });

        socket.On("chat", data => {
            Debug.Log("data : " + data);
        });
    }

    private void OnDestroy()
    {
        socket.Disconnect();
    }
}