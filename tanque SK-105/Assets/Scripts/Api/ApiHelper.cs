using UnityEngine;
using System.Net;
using System.IO;

public static class ApiHelper
{
    public static SetStart LoadState(){
        HttpWebRequest  request = (HttpWebRequest)WebRequest.Create("http://127.0.0.1:8000/api/simulatorState");
        HttpWebResponse response =(HttpWebResponse)request.GetResponse();
        StreamReader reader = new StreamReader(response.GetResponseStream());
        string json = reader.ReadToEnd();
        return JsonUtility.FromJson<SetStart>(json);     
    }
    public static void Start(){
        HttpWebRequest  request = (HttpWebRequest)WebRequest.Create("http://127.0.0.1:8000/api/setStart");
        HttpWebResponse response =(HttpWebResponse)request.GetResponse();
        // StreamReader reader = new StreamReader(response.GetResponseStream());
        // string json = reader.ReadToEnd();
        // return JsonUtility.FromJson<SetStart>(json);     
    }
}
