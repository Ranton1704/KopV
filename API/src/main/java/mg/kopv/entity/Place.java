package mg.kopv.api.entity;

import jakarta.persistence.*;

@Entity
@Table(name = "places")
public class Place {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;

    @ManyToOne
    @JoinColumn(name = "id_vehicule", nullable = false)
    private Vehicule vehicule;

    @Column(name = "numero", nullable = false, length = 10)
    private String numero;

    public Place() {}

    public Integer getId() { return id; }
    public void setId(Integer id) { this.id = id; }

    public Vehicule getVehicule() { return vehicule; }
    public void setVehicule(Vehicule vehicule) { this.vehicule = vehicule; }

    public String getNumero() { return numero; }
    public void setNumero(String numero) { this.numero = numero; }
}
