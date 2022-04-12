using UnityEngine;

public class BulletController : MonoBehaviour {
    [SerializeField] BulletData bulletData;

    Rigidbody rb;
    void Start() {
        rb = GetComponent<Rigidbody>();
    }

    public void Init(BulletData bulletData) {
        this.bulletData = bulletData;
        rb.velocity = transform.forward * bulletData.initialVelocity;
    }

    private void OnTriggerEnter(Collider other) {
        if (other.CompareTag("Enemy")) {
            // other.gameObject.GetComponent<EnemyController>().TakeDamage(bulletData.damage);
            Destroy(gameObject);
        }
    }
}
