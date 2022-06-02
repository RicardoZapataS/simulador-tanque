using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using TMPro;

[RequireComponent(typeof(InstanceSync))]
[RequireComponent(typeof(TransformSync))]
[RequireComponent(typeof(AudioSource))]
public class Canyon : MonoBehaviour {

    [SerializeField] GameObject uiCanvas;
    [SerializeField] GameObject uiHostCanvas;
    [SerializeField] TextMeshProUGUI textAmmo;
    [SerializeField] GameObject mainCamera;
    [SerializeField] GameObject secondaryCamera;

    [SerializeField, Range(0, 1000)] int _distance = 1;
    [SerializeField] GameObject _projectilePrefab;
    [SerializeField] Transform _shootingPoint;
    [SerializeField] AudioClip shootSound, outOfAmmo;

    [SerializeField] float smooth = 5.0f;

    int currentAmmo, maxAmmo;
    AudioSource audioSource;
    InstanceSync remoteInstantiate;

    RoomSetting setting;

    public static Canyon singletone;

    void Start() {
        setting = UserData.RoomSetting;
        singletone = this;
        audioSource = GetComponent<AudioSource>();
        mainCamera.SetActive(TCPManager.Main.isServer);
        secondaryCamera.SetActive(!TCPManager.Main.isServer);
        remoteInstantiate = GetComponent<InstanceSync>();

        remoteInstantiate.onRemoteInstance += ReceivedInstanceProjectile;

        uiCanvas.SetActive(!TCPManager.Main.isServer);
        uiHostCanvas.SetActive(TCPManager.Main.isServer);
        currentAmmo = maxAmmo = setting.ammountBullet;
        textAmmo.text = $"Municion: {currentAmmo}/{maxAmmo}";
    }

    private void Update() {
        if (!TCPManager.Main.isServer) return;
        if (Input.GetKeyDown(KeyCode.Space) && currentAmmo > 0 && currentAmmo <= maxAmmo)
            ShootProjectile();
        else if (Input.GetKeyDown(KeyCode.Space) && currentAmmo <= 0)
            audioSource?.PlayOneShot(outOfAmmo);

        float x = Input.GetAxis("Horizontal");

        if (x != 0)
            transform.Rotate(Vector3.up * smooth * Time.deltaTime * x, Space.World);

        float y = Input.GetAxis("Vertical");

        if (y != 0)
            transform.Rotate(Vector3.forward * smooth * Time.deltaTime * y, Space.World);
    }

    // private void ShootProjectile() {
    //     GameObject projectile = Instantiate(_projectilePrefab, _shootingPoint.position, Quaternion.identity);
    //     if (projectile.TryGetComponent(out BulletController bulletController)) {
    //         remoteInstantiate.InstanceGO(transform, UserData.BulletData);
    //         bulletController.Init(transform, UserData.BulletData);
    //         // projectileRigidbody.velocity = transform.up * _distance;
    //         audioSource?.PlayOneShot(shootSound);
    //     }
    // }
     private void ShootProjectile()
    {
        GameObject projectile = Instantiate(_projectilePrefab, _shootingPoint.position, Quaternion.identity); 
        Rigidbody projectileRigidbody = null; 
        if(projectile.GetComponent<Rigidbody>() != null)
        {
            projectileRigidbody = projectile.GetComponent<Rigidbody>();
        }
        currentAmmo --;
        if (currentAmmo <= 0) currentAmmo = 0;
        textAmmo.text = $"Municion: {currentAmmo}/{maxAmmo}";
    }

    void ReceivedInstanceProjectile(RemoteBulletData data) {
        GameObject projectile = Instantiate(_projectilePrefab, data.position, Quaternion.identity);
        if (projectile.TryGetComponent(out BulletController bulletController)) {
            bulletController.Init(transform, data);
            // projectileRigidbody.velocity = transform.up * _distance;
            audioSource?.PlayOneShot(shootSound);
        }
    }

    private void OnDrawGizmos() {
        Debug.DrawLine(transform.position, transform.position + transform.up * _distance);
    }
    public void RotateCanyon(Vector3 axis, float angle) {
        Quaternion target = transform.rotation * Quaternion.AngleAxis(angle, axis);
        transform.rotation = target;
    }

    public void Impacted (string tag, string name) {
        print($"{tag} - {name}");

        int tagInt = tag switch {
            "Oruga" => 0,
            "Canon" => 1,
            "Batea" => 2,
            "Cabina" => 3,
            _ => -1
        };

        ApiHelper.ShootingTarget($"{RoomManager.Main.currentTime}", tagInt, name.Split('_')[1]);
        
    }
}
