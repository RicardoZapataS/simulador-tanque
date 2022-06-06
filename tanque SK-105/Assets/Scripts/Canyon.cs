using UnityEngine;
using TMPro;
using BeardedManStudios.Forge.Networking.Generated;
using BeardedManStudios.Forge.Networking;

[RequireComponent(typeof(AudioSource))]
public class Canyon : TankBehavior {

    [SerializeField] GameObject uiHostCanvas;
    [SerializeField] TextMeshProUGUI textAmmo;
    [SerializeField] GameObject mainCamera;
    [SerializeField] GameObject secondaryCamera;
    [SerializeField] GameObject miraGameObject;

    [SerializeField, Range(0, 1000)] int _distance = 1;
    [SerializeField] GameObject _projectilePrefab;
    [SerializeField] Transform _shootingPoint;
    [SerializeField] AudioClip shootSound, outOfAmmo;

    [SerializeField] float smooth = 5.0f;

    int currentAmmo, maxAmmo;
    AudioSource audioSource;

    RoomSetting setting;

    public static Canyon singletone;

    void Start() {
        setting = UserData.RoomSetting;
        singletone = this;
        audioSource = GetComponent<AudioSource>();
        mainCamera.SetActive(TCPManager.Main.isServer);
        secondaryCamera.SetActive(!TCPManager.Main.isServer);

        miraGameObject.SetActive(!TCPManager.Main.isServer);
        textAmmo.gameObject.SetActive(TCPManager.Main.isServer);
        currentAmmo = maxAmmo = setting.ammountBullet;
        textAmmo.text = $"Municion: {currentAmmo}/{maxAmmo}";

		NetworkObject.Flush(TCPManager.Main.netWorker);
    }

    private void Update() {
        if (RoomManager.Main.endGame || RoomManager.Main.pauseGame) return;
        if (networkObject == null) return;
		if (!networkObject.IsOwner) {
            transform.position = networkObject.position;
			transform.rotation = networkObject.rotation;
        } else {
            if (Input.GetKeyDown(KeyCode.Space) && currentAmmo > 0 && currentAmmo <= maxAmmo)
                Shoot();
                // networkObject.SendRpc(RPC_SHOOT, Receivers.All);
            else if (Input.GetKeyDown(KeyCode.Space) && currentAmmo <= 0)
                audioSource?.PlayOneShot(outOfAmmo);

            float x = Input.GetAxis("Horizontal");

            if (x != 0)
                transform.Rotate(Vector3.up * smooth * Time.deltaTime * x, Space.World);

            float y = Input.GetAxis("Vertical");

            if (y != 0)
                transform.Rotate(Vector3.forward * smooth * Time.deltaTime * y, Space.World);

            networkObject.position = transform.position;
            networkObject.rotation = transform.rotation;
        }
    }

    void Shoot() {
        GameObject projectile = Instantiate(_projectilePrefab, _shootingPoint.position, Quaternion.identity);
        if (projectile.TryGetComponent(out BulletController bulletController)) {
            bulletController.Init(transform, UserData.BulletData);
            // projectileRigidbody.velocity = transform.up * _distance;
            audioSource?.PlayOneShot(shootSound);
        }
        currentAmmo --;
        if (currentAmmo <= 0) {
            currentAmmo = 0;
            Invoke("InternalEndGame", 10f);
        }
        textAmmo.text = $"Municion: {currentAmmo}/{maxAmmo}";
    }

    void InternalEndGame() => networkObject.SendRpc(RPC_END_GAME, Receivers.All);

    public override void EndGame(RpcArgs args) => RoomManager.Main.EndGame();

    private void OnDrawGizmos() {
        Debug.DrawLine(transform.position, transform.position + transform.up * _distance);
    }
    public void RotateCanyon(Vector3 axis, float angle) {
        Quaternion target = transform.rotation * Quaternion.AngleAxis(angle, axis);
        transform.rotation = target;
    }

    public void Impacted (string tag, string name) {
        if (!TCPManager.Main.isServer) return;
        print($"{tag} - {name}");

        int tagInt = tag switch {
            "Oruga" => 0,
            "Canon" => 1,
            "Batea" => 2,
            "Cabina" => 3,
            _ => -1
        };

        string correctName = name.Contains("_") || !string.IsNullOrEmpty(name) ?  name.Split('_')[1] : "-1";

        ApiHelper.ShootingTarget($"{RoomManager.Main.currentTime}", tagInt, correctName);
        
    }
}
