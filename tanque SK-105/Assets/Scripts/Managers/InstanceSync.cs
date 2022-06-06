using System;
using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class InstanceSync : MonoBehaviour {

    TCPManager tcp;
    int id;

    public event Action<RemoteBulletData> onRemoteInstance;

    void Start() {
        tcp = TCPManager.Main;
        id = gameObject.GetInstanceID();

        tcp.addListener(id, OnDataReceiver);
    }

    void OnDataReceiver (PackerData packer) {
        switch (packer.type) {
            case TypeDataPackage.Instance:
                RemoteBulletData remoteData = (RemoteBulletData) packer.data;
                onRemoteInstance?.Invoke(remoteData);
                break;
        }
    }

    public void InstanceGO(Transform t, BulletData d) {
        if (!tcp.isServer) throw new Exception("This game instance is not a Host of Tcp Connection");
        RemoteBulletData data = new RemoteBulletData () {
            typeBullet = d.typeBullet,
            initialVelocity = d.initialVelocity,
            weight = d.weight,
            position = t.position,
            scale = t.localScale,
            rotation = t.rotation.eulerAngles
        };

        tcp.sendData<RemoteBulletData>(TypeDataPackage.Instance, id, data);
    }
}
