using UnityEngine;

public class BulletController : MonoBehaviour {
    [SerializeField] BulletData bulletData;

    Rigidbody rb;

    public void Init(Transform from, BulletData bulletData) {
        this.bulletData = bulletData;
        rb = GetComponent<Rigidbody>();
        rb.velocity = from.up * bulletData.initialVelocity;
        Destroy(gameObject, 15);
    }

    private void OnTriggerEnter(Collider other) {
        if (other.CompareTag("Enemy")) {
            // other.gameObject.GetComponent<EnemyController>().TakeDamage(bulletData.damage);
            Destroy(gameObject);
        }
    }
}
