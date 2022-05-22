using UnityEngine;

public class BulletController : MonoBehaviour {

    [SerializeField] BulletData bulletData;
    [SerializeField] GameObject explosionPrefab;

    Rigidbody rb;

    public void Init(Transform from, BulletData bulletData) {
        this.bulletData = bulletData;
        rb = GetComponent<Rigidbody>();
        rb.velocity = from.up * bulletData.initialVelocity;
        Destroy(gameObject, 15);
    }

    void OnTriggerEnter(Collider other) {
        print(other.name);
        Canyon.singletone.Inpacted(other.tag);
        Destroy(Instantiate(explosionPrefab, transform.position, Quaternion.identity), 5f);
        Destroy(gameObject);
    }

    void OnCollisionEnter (Collision col) {
        Collider other = col.collider;
        print(other.name);
        Canyon.singletone.Inpacted(other.tag);
        Destroy(Instantiate(explosionPrefab, transform.position, Quaternion.identity), 5f);
        Destroy(gameObject);
    }
}
