using System;

[Serializable]
public class BulletData {
    public TypeBullet typeBullet;
    public float initialVelocity, weight;

    public BulletData(float initialVelocity, float weight) {
        this.initialVelocity = initialVelocity;
        this.weight = weight;
    }
}
