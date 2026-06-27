package mg.kopv.api.entity;

import jakarta.persistence.*;

@Entity
@Table(name = "reservations_fille")
public class ReservationFille {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;

    @ManyToOne
    @JoinColumn(name = "id_reservation_mere", nullable = false)
    private ReservationMere reservationMere;

    @ManyToOne
    @JoinColumn(name = "id_place", nullable = false)
    private Place place;

    public ReservationFille() {}

    public Integer getId() { return id; }
    public void setId(Integer id) { this.id = id; }

    public ReservationMere getReservationMere() { return reservationMere; }
    public void setReservationMere(ReservationMere reservationMere) { this.reservationMere = reservationMere; }

    public Place getPlace() { return place; }
    public void setPlace(Place place) { this.place = place; }
}
