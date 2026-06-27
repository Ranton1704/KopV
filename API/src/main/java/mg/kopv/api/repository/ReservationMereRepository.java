package mg.kopv.api.repository;

import mg.kopv.api.entity.Client;
import mg.kopv.api.entity.ReservationMere;
import mg.kopv.api.entity.Voyage;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.time.LocalDateTime;
import java.util.List;

@Repository
public interface ReservationMereRepository extends JpaRepository<ReservationMere, Integer> {

    // Utilisé par /api/reservation/list (filtre date + trajet via voyage)
    Page<ReservationMere> findByVoyageAndDateReservationBetween(
            Voyage voyage, LocalDateTime debut, LocalDateTime fin, Pageable pageable);

    // Utilisé par /api/client/{id} (historique réservations)
    List<ReservationMere> findByClient(Client client);
}
