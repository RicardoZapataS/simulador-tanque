using System;
using System.Runtime;
using UnityEngine;

public class BulletController : MonoBehaviour {

    [SerializeField] float lifeTime = 15f;
    [SerializeField] BulletData bulletData;
    [SerializeField] GameObject explosionPrefab;

    Rigidbody rb;

    string tagCollision = "";

    public void Init(Transform from, BulletData bulletData) {
        this.bulletData = bulletData;
        rb = GetComponent<Rigidbody>();
        rb.velocity = from.forward * bulletData.initialVelocity;
        Invoke("DestroyMe", lifeTime);
    }

    void OnTriggerEnter(Collider other) {
        print(other.name);
        Canyon.singletone.Impacted(other.tag, other.name);
        DestroyMe();
    }

    void OnCollisionEnter (Collision col) {
        Collider other = col.collider;
        print(other.name);
        Canyon.singletone.Impacted(other.tag, other.name);
        DestroyMe();
    }

    void DestroyMe() {
        print("Destroy bullet");
        Destroy(Instantiate(explosionPrefab, transform.position, Quaternion.identity), 5f);
        Destroy(gameObject);
    }
}
