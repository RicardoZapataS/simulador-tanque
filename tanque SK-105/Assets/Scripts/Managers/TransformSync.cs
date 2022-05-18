using System;
using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using TMPro;


public class TransformSync : MonoBehaviour {

    [SerializeField] TextMeshProUGUI textPos, textRot;

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
        showUI();
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
        showUI();
    }

    void showUI () {
        var t = transform;
        textPos.text = $"<b>Position:</b>\n<b>x:{t.position.x}</b>\n<b>y:{t.position.y}</b>\n<b>z:{t.position.z}</b>";
        textRot.text = $"<b>Rotation:</b>\n<b>x:{t.rotation.x}</b>\n<b>y:{t.rotation.y}</b>\n<b>z:{t.rotation.z}</b>";
    }
}
