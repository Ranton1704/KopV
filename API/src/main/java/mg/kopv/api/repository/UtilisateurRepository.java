package mg.kopv.api.repository;

import mg.kopv.api.entity.Utilisateur;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.util.Optional;

@Repository
public interface UtilisateurRepository extends JpaRepository<Utilisateur, Integer> {

    // Utilisé par /api/auth/login
    Optional<Utilisateur> findByEmail(String email);

    boolean existsByEmail(String email);
}
