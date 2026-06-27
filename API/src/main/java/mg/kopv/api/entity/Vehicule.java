package mg.kopv.api.entity;

import jakarta.persistence.*;

@Entity
@Table(name = "vehicules")
public class Vehicule {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;

    @Column(name = "immatriculation", nullable = false, unique = true, length = 20)
    private String immatriculation;

    @Column(name = "modele", nullable = false, length = 100)
    private String modele;

    @ManyToOne
    @JoinColumn(name = "id_categorie", nullable = false)
    private CategorieVehicule categorieVehicule;

    @Column(name = "nombre_places", nullable = false)
    private Short nombrePlaces;

    public Vehicule() {}

    public Integer getId() { return id; }
    public void setId(Integer id) { this.id = id; }

    public String getImmatriculation() { return immatriculation; }
    public void setImmatriculation(String immatriculation) { this.immatriculation = immatriculation; }

    public String getModele() { return modele; }
    public void setModele(String modele) { this.modele = modele; }

    public CategorieVehicule getCategorieVehicule() { return categorieVehicule; }
    public void setCategorieVehicule(CategorieVehicule categorieVehicule) { this.categorieVehicule = categorieVehicule; }

    public Short getNombrePlaces() { return nombrePlaces; }
    public void setNombrePlaces(Short nombrePlaces) { this.nombrePlaces = nombrePlaces; }
}
