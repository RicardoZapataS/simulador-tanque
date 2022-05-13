using System;
using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using System.Runtime.CompilerServices;
using System.Security.Cryptography;

public class TransformSync : MonoBehaviour {

    TCPManager tcp;

    Vector3 lastPos, lastScale, lastRotation;

    int id;

    // Start is called before the first frame update
    void Start() {
        tcp = TCPManager.Main;
        id = gameObject.GetInstanceID();

        lastPos = transform.position;
        lastScale = transform.localScale;
        lastRotation = transform.rotation.eulerAngles;

        tcp.addListener(id, OnDataReceiver);
    }

    void OnDataReceiver (PackerData packer) {
        switch (packer.type) {
            case TypeDataPackage.Position:
                transform.position = lastPos = (Vector3) packer.data;
                break;
            case TypeDataPackage.Rotation:
                lastRotation = (Vector3) packer.data;
                transform.rotation = Quaternion.Euler(lastRotation);
                break;
            case TypeDataPackage.Scale:
                transform.localScale = lastScale = (Vector3) packer.data;
                break;
        }
    }

    void LateUpdate() {
        if (transform.position != lastPos) {
            tcp.sendData<Vector3>(TypeDataPackage.Position, gameObject.GetInstanceID(), lastPos);
            lastPos = transform.position;
        }
        if (transform.rotation.eulerAngles != lastRotation) {
            tcp.sendData<Vector3>(TypeDataPackage.Rotation, gameObject.GetInstanceID(), lastRotation);
            lastRotation = transform.rotation.eulerAngles;
        }
        if (transform.localScale != lastScale) {
            tcp.sendData<Vector3>(TypeDataPackage.Scale, gameObject.GetInstanceID(), lastScale);
            lastScale = transform.localScale;
        }
    }
}
