using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using System;
using TMPro;
using BeardedManStudios.Forge.Networking.Generated;
using BeardedManStudios.Forge.Networking;
using UnityEngine.UI;

[RequireComponent(typeof(AudioSource))]
public class Canyon : TankBehavior
{


    [SerializeField] Sprite[] TargetTextures;
    [SerializeField] Image CanvaImage;


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

    void Start()
    {

        setting = UserData.RoomSetting;
        singletone = this;
        audioSource = GetComponent<AudioSource>();
        mainCamera.SetActive(TCPManager.Instance.isServer);
        secondaryCamera.SetActive(!TCPManager.Instance.isServer);

        miraGameObject.SetActive(!TCPManager.Instance.isServer);
        textAmmo.gameObject.SetActive(TCPManager.Instance.isServer);
        currentAmmo = maxAmmo = setting.ammountBullet;
        textAmmo.text = $"Municion: {currentAmmo}/{maxAmmo}";

        NetworkObject.Flush(TCPManager.Instance.netWorker);
    }

    private void Update()
    {
        if (RoomManager.Main.endGame || RoomManager.Main.pauseGame) return;
        if (networkObject == null) return;
        if (!networkObject.IsOwner)
        {
            transform.position = networkObject.position;
            transform.rotation = networkObject.rotation;
            Debug.Log(transform.rotation);
        }
        else
        {
            networkObject.position = transform.position;
            networkObject.rotation = transform.rotation;
            if (Input.GetKeyDown(KeyCode.Space) && currentAmmo > 0 && currentAmmo <= maxAmmo)
                Shoot();
            // networkObject.SendRpc(RPC_SHOOT, Receivers.All);
            else if (Input.GetKeyDown(KeyCode.Space) && currentAmmo <= 0)
                audioSource?.PlayOneShot(outOfAmmo);

            if (Input.GetKeyDown(KeyCode.Alpha1)){

                mainCamera.SetActive(!TCPManager.Instance.isServer);
                secondaryCamera.SetActive(TCPManager.Instance.isServer);

                miraGameObject.SetActive(TCPManager.Instance.isServer);
                textAmmo.gameObject.SetActive(!TCPManager.Instance.isServer);
            }
            else if (Input.GetKeyDown(KeyCode.Alpha2))
            {
                mainCamera.SetActive(TCPManager.Instance.isServer);
                secondaryCamera.SetActive(!TCPManager.Instance.isServer);

                miraGameObject.SetActive(!TCPManager.Instance.isServer);
                textAmmo.gameObject.SetActive(TCPManager.Instance.isServer);
            }

            float x = Input.GetAxis("Horizontal");
            float y = Input.GetAxis("Vertical");

            if (x > 0)
            {
                x = 1;
            }
            else if (x < 0)
            {
                x = -1;
            }

            if (y > 0)
            {
                y = 1;
            }
            else if (y < 0)
            {
                y = -1;
            }

            if (x != 0)
                transform.Rotate(Vector3.up * smooth * Time.deltaTime * x, Space.World);


            if (y != 0)     
                transform.Rotate(Vector3.right * Time.deltaTime * smooth  * y, Space.Self);

            
            
        }
    }

    void Shoot()
    {
        GameObject projectile = Instantiate(_projectilePrefab, _shootingPoint.position, Quaternion.identity);
        if (projectile.TryGetComponent(out BulletController bulletController))
        {
            bulletController.Init(transform, UserData.BulletData);
            // projectileRigidbody.velocity = transform.up * _distance;
            audioSource?.PlayOneShot(shootSound);
        }
        currentAmmo--;
        if (currentAmmo <= 0)
        {
            currentAmmo = 0;
            Invoke("InternalEndGame", 10f);
        }
        textAmmo.text = $"Municion: {currentAmmo}/{maxAmmo}";
    }

    void InternalEndGame() => networkObject.SendRpc(RPC_END_GAME, Receivers.All);

    public override void EndGame(RpcArgs args) => RoomManager.Main.EndGame();

    private void OnDrawGizmos()
    {
        Debug.DrawLine(transform.position, transform.position + transform.up * _distance);
    }
    public void RotateCanyon(Vector3 axis, float angle)
    {
        Quaternion target = transform.rotation * Quaternion.AngleAxis(angle, axis);
        transform.rotation = target;
    }

    public void Impacted(string tag, string name)
    {
        if (!TCPManager.Instance.isServer) return;
        print($"{tag} - {name}");

        int tagInt = tag switch
        {
            "Oruga" => 0,
            "Canon" => 1,
            "Batea" => 2,
            "Cabina" => 3,
            _ => -1
        };
        CanvaImage.sprite = TargetTextures[tagInt == -1 ? 5 : tagInt];
        Debug.Log("TargetO " + (tagInt).ToString());
        Debug.Log("Target " + (tagInt == -1 ? 5 : tagInt).ToString());
        string correctName = name.Contains("_") || !string.IsNullOrEmpty(name) ? name.Split('_')[1] : "-1";

        ApiHelper.ShootingTarget($"{RoomManager.Main.currentTime}",  tagInt, correctName);

    }

}
