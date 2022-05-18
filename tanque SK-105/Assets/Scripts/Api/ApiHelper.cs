using UnityEngine;
using System.Net;
using System.IO;

public static class ApiHelper {

    public const string URL = "http://asa.inventiva.com.bo/api";

    public static SetStart LoadState(){
        HttpWebRequest  request = (HttpWebRequest) WebRequest.Create($"{URL}/simulatorState");
        HttpWebResponse response =(HttpWebResponse)request.GetResponse();
        StreamReader reader = new StreamReader(response.GetResponseStream());
        string json = reader.ReadToEnd();
        return JsonUtility.FromJson<SetStart>(json);     
    }
}
