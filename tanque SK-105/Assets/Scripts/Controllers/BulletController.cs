using System;
using System.Runtime;
using UnityEngine;

public class BulletController : MonoBehaviour {

    [SerializeField] float lifeTime = 5f;
    [SerializeField] BulletData bulletData;
    [SerializeField] GameObject explosionPrefab;

    Rigidbody rb;
    string otherTag = string.Empty, otherName = string.Empty;

    string tagCollision = "";

    public void Init(Transform from, BulletData bulletData) {
        this.bulletData = bulletData;
        rb = GetComponent<Rigidbody>();
        rb.velocity = from.up * bulletData.initialVelocity;
        Invoke("DestroyMe", lifeTime);
    }

    void OnTriggerEnter(Collider other) {
        print(other.name);
        otherName = other.name;
        otherTag = other.tag;
        DestroyMe();
    }

    void OnCollisionEnter (Collision col) {
        otherName = col.collider.name;
        otherTag = col.collider.tag;
        print(col.collider.name);
        DestroyMe();
    }

    void DestroyMe() {
        print("Destroy bullet");
        Canyon.singletone.Impacted(otherTag, otherName);
        Destroy(Instantiate(explosionPrefab, transform.position, Quaternion.identity), 5f);
        Destroy(gameObject);
    }
}
