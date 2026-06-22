package mg.kopv.api.controller;

import java.util.HashMap;
import java.util.Map;

import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

@RestController
@RequestMapping("/test")
public class TestController {

    @GetMapping("/succes")
    public ResponseEntity<Map<String, Object>> succes() {
        Map<String, Object> response = new HashMap<>();
        response.put("message", "Hello, World!");
        response.put("status", "success");
        return ResponseEntity.ok(response);
    }

    @GetMapping("/erreur")
    public ResponseEntity<Map<String, Object>> erreur() {
        Map<String, Object> response = new HashMap<>();
        response.put("message", "Good bye, You!");
        response.put("status", "error");
        return ResponseEntity.badRequest().body(response);
    }
}
