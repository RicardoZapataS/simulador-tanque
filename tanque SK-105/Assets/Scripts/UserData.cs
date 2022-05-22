public static class UserData {

    static BulletData bulletData;
    static Dificulty dificulty;

    public static BulletData BulletData {
        get => bulletData ?? new BulletData() {
            typeBullet = TypeBullet.Practica,
            initialVelocity = 800,
            weight = 17.3f
        };
        set => bulletData = value;
    }

    public static Dificulty Dificulty {
        get => dificulty;
        set => dificulty = value;
    }

}
