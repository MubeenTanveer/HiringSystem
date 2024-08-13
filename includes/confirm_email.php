<?php
if (isset($_POST['submit'])) {

  // Email parameters
  $to = $_POST['to'];
  $subject = $_POST['subject'];
  $message = $_POST['message'];
  $from = "bsit-fa20-008@tuf.edu.pk";
  $headers = "From : $from";
  echo $to;
  echo $subject;
  echo $message;
  // Send email
  if (mail($to, $subject, $message, $headers)) {
    echo "Mail Sended";
  } else {
    echo "Email sending failed.";
  }
}
?>
<?php
if (isset($_POST['mail'])) {
$userq = $conex->query("SELECT U.FNAME, U.RESUMESCORE, U.LNAME, U.EMAIL, U.PHONE, U.QUALI, U.EXP, U.STATUS, U.CODE USER_CODE, R.QUEST_CODE, SUM(R.ANS) ANS FROM `users` U, result R WHERE U.CODE = R.USER_CODE AND R.ANS = 1 AND U.STATUS = 5 GROUP BY R.USER_CODE ORDER BY (SUM(R.ANS)+U.QUALI+u.EXP) ASC");
while ($data = $userq->fetch_assoc()) {
  $to = $data['EMAIL'];
  $subject = "Invitation for Interview - Congratulations!";
  $message = "
  Dear {$data['FNAME']} {$data['LNAME']},

We are delighted to inform you that after reviewing your resume, test and qualifications, you have been selected for the next stage in our hiring process. Congratulations on being shortlisted for an interview in company name .

We were impressed by your skills experience qualities and believe that you would be a valuable addition to our team. Your application stood out among many others, and we are eager to learn more about you during the interview.
During the interview, we will discuss your background, skills, and experiences in more detail. Please come prepared to talk about your achievements, career goals, and how you can contribute to our organization.
Interview Details:

Date: 20/5/2024
Time: 9:PM PAK Time
Location: Head Office Lahore 
  
  ";
  $from = "bsit-fa20-008@tuf.edu.pk";
  $headers = "From : $from";

  if (mail($to, $subject, $message, $headers)) {
    echo "Mail Sended";
  } else {
    echo "Email sending failed.";
  }

}
}
?>





<!DOCTYPE html>
<html>

<head>
  <title>Mail to</title>
</head>

<body>
  <h1>Contact Us</h1>
  <form method="post">
    <label for="to">To:</label>
    <input type="text" id="to" name="to" placeholder="To.."><br>

    <label for="subject">Subject:</label>
    <input type="text" id="subject" name="subject" placeholder="Subject.."><br>

    <label for="message">Message:</label><br>
    <input type="text" id="message" name="message" placeholder="MSG.."><br>
    <button name="submit" id="submit" type="submit">Send</button>
  </form>
</body>

</html>