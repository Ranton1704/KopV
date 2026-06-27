package mg.kopv.repository;

import mg.kopv.api.entity.Voyage;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.time.LocalDateTime;
import java.util.List;

@Repository
public interface VoyageRepository extends JpaRepository<Voyage, Integer> {

    // Utilisé par /api/voyage/list?date=
    List<Voyage> findByDateHeureDepartBetween(LocalDateTime debut, LocalDateTime fin);
}
