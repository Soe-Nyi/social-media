<?php
include('../include/config.php');

// $lastMessageId = isset($_POST['lastMessageId']) ? intval($_POST['lastMessageId']) : 0;

// $maxWaitTime = 30; // Maximum wait time in seconds
// $startTime = time();

// while (true) {
//     $query = "SELECT * FROM message WHERE id > :lastMessageId ORDER BY timestamp ASC";
//     $stmt = $pdo->prepare($query);
//     $stmt->bindParam(':lastMessageId', $lastMessageId, PDO::PARAM_INT);
//     $stmt->execute();
//     $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

//     if (!empty($messages)) {
//         foreach ($messages as $message) {
//             $output = '<li class="media hover-media">';
//             $output .= '<div class="media-body text-dark text-right">';
//             $output .= '<h6 class="media-header">' . htmlspecialchars($message['user']) . '</h6>';
//             $output .= '<p class="media-text">' . htmlspecialchars($message['message']) . '</p>';
//             $output .= '</div>';
//             $output .= '<img src="img/avatar-fat.jpg" alt="img" width="55px" height="55px" class="rounded-circle ml-3">'; 
//             $output .= '</li>';
//             echo $output;

//             // Update last message ID
//             $lastMessageId = $message['id'];
//         }
//         break;
//     }

//     if (time() - $startTime >= $maxWaitTime) {
//         // No new messages, send an empty response
//         echo json_encode([]);
//         break;
//     }

//     // Wait for a short time before checking again (customize as needed)
//     sleep(1);
// }

?>