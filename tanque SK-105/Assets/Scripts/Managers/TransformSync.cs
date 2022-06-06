using UnityEngine;


public class TransformSync : MonoBehaviour {

    TCPManager tcp;
    [SerializeField] Vector3 lastPos, lastScale, lastRotation;
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
        if (!tcp.isServer) return;
        if (transform.position != lastPos) {
            tcp.sendData<Vector3>(TypeDataPackage.Position, id, lastPos);
            lastPos = transform.position;
        }
        if (transform.rotation.eulerAngles != lastRotation) {
            tcp.sendData<Vector3>(TypeDataPackage.Rotation, id, lastRotation);
            lastRotation = transform.rotation.eulerAngles;
        }
        if (transform.localScale != lastScale) {
            tcp.sendData<Vector3>(TypeDataPackage.Scale, id, lastScale);
            lastScale = transform.localScale;
        }
    }
}
