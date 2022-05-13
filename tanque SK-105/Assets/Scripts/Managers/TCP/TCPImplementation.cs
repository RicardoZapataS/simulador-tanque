using System;

public interface TCPImplementation {
    void sendData (string data);
    void setOnDataListener (Action<string> listener);
    void setOnDisconnect (Action listener);
    void setOnError (Action<Exception> listener);
}