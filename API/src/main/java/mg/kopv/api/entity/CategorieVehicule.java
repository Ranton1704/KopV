package mg.kopv.api.entity;

import jakarta.persistence.*;

@Entity
@Table(name = "categorie_vehicule")
public class CategorieVehicule {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;

    @Column(name = "libelle", nullable = false, length = 50)
    private String libelle;

    public CategorieVehicule() {}

    public Integer getId() { return id; }
    public void setId(Integer id) { this.id = id; }

    public String getLibelle() { return libelle; }
    public void setLibelle(String libelle) { this.libelle = libelle; }
}
