package mg.kopv.repository;

import mg.kopv.api.entity.Place;
import mg.kopv.api.entity.ReservationFille;
import mg.kopv.api.entity.ReservationMere;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.util.List;
import java.util.Optional;

@Repository
public interface ReservationFilleRepository extends JpaRepository<ReservationFille, Integer> {

    List<ReservationFille> findByReservationMere(ReservationMere reservationMere);

    // Utilisé pour calculer les places occupées d'un véhicule/voyage
    Optional<ReservationFille> findByPlace(Place place);

    boolean existsByPlace(Place place);
}
