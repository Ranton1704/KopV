package mg.kopv.repository;

import mg.kopv.api.entity.Gare;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

@Repository
public interface GareRepository extends JpaRepository<Gare, Integer> {
}
