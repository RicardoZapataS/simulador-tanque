using UnityEngine;
using System.Net;
using System.IO;

public static class ApiHelper {

    public const string URL = "https://asa.inventiva.com.bo/api";
    /* public const string URL = "http://127.0.0.1:8000/api"; */

    public static SetStart LoadState(){
        HttpWebRequest  request = (HttpWebRequest) WebRequest.Create($"{URL}/simulatorState");
        HttpWebResponse response =(HttpWebResponse)request.GetResponse();
        StreamReader reader = new StreamReader(response.GetResponseStream());
        string json = reader.ReadToEnd();
        return JsonUtility.FromJson<SetStart>(json);     
    }

    public static SetStart SetState(string value){
        HttpWebRequest  request = (HttpWebRequest) WebRequest.Create($"{URL}/setState/{value}");
        HttpWebResponse response =(HttpWebResponse)request.GetResponse();
        StreamReader reader = new StreamReader(response.GetResponseStream());
        string json = reader.ReadToEnd();
        Debug.Log(value);
        return JsonUtility.FromJson<SetStart>(json);     
    }

    public static RoomSetting GetRoomSetting(){
        HttpWebRequest  request = (HttpWebRequest) WebRequest.Create($"{URL}/getRoomSetting");
        HttpWebResponse response =(HttpWebResponse)request.GetResponse();
        StreamReader reader = new StreamReader(response.GetResponseStream());
        string json = reader.ReadToEnd();
        Debug.Log(json);
        return JsonUtility.FromJson<RoomSetting>(json);     
    }

    public static void ShootingTarget(string time, int site_shooting, string target){
        HttpWebRequest  request = (HttpWebRequest) WebRequest.Create($"{URL}/shootingTarget/{time}/{site_shooting}/{target}");
        HttpWebResponse response =(HttpWebResponse)request.GetResponse();
        StreamReader reader = new StreamReader(response.GetResponseStream());
    }
}
