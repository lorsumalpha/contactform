<?php

const MAIL_TO = 'homestead@homestead.io';

function sanitize(): array {
    $data = array_merge($_GET, $_POST);

    foreach ($data as $key => $value) {
        $cleaned = htmlspecialchars($value);

        $data[$key] = $cleaned;
    }

    return $data;
}

/**
 * @throws Exception
 */
function mailFromFormInput() {
    $data = sanitize();
    if (empty($data)) {
        throw new \Exception('data is empty');
    }
    $name = $data['name'];
    $mail = $data['mail'];
    $comment = $data['comment'];
    $issue = $data['issue'];

    $message = "Name: $name\nMail: $mail\nIssue: $issue\nComment: \n$comment\n";

    mail(MAIL_TO, 'New form submission', $message);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple web contact form</title>
    <style>
        body {
            max-width: 29rem;
            margin: 0 auto;
            font-family: sans-serif;
            padding: 2rem;
        }
        form {
            display: flex;
            flex-direction: column;
        }
    </style>
</head>
<body>
<h1>Simple web contact form</h1>
<div class="content">
    <form action='index2.php' method="post">
        <?php
        $simpleFields = [
            'name' => [
                'type' => 'text',
                'title' => 'Name',
            ],
            'mail' => [
                'type' => 'email',
                'title' => 'E-Mail',
            ],
            'comment' => [
                'type' => 'text',
                'title' => 'Comment',
            ],
            'issue' => [
                'type' => 'select',
                'title' => 'Issue',
                'options' => [
                    'query' => 'Query',
                    'feedback' => 'Feedback',
                    'complaint' => 'Complaint',
                    'other' => 'Other',
                ],
            ],
            'submit' => [
                'type' => 'submit',
                'value' => 'Absenden',
            ],
        ];
        ?>

        <?php foreach ($simpleFields as $key => $field) { ?>
            <?php if (!in_array($field['type'], ['hidden', 'submit'])) { ?>
                <label for="<?php echo $key; ?>"><?php echo $field['title']; ?></label>
            <?php } ?>
            <?php if (!in_array($field['type'], ['select', 'submit'])) { ?>
                <input name="<?php echo $key; ?>" id="<?php echo $key; ?>" type="<?php echo $field['title']; ?>">
            <?php } elseif ($field['type'] == 'select') { ?>
                <select name="<?php echo $key; ?>">
                    <?php if (isset($field['options'])) { ?>
                        <?php foreach ($field['options'] as $name => $label) { ?>
                            <option value="<?php echo $name; ?>"><?php echo $label; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            <?php } else { ?>
                <input type="submit" name="submit" value="<?php echo $field['value']; ?>" />
            <?php } ?>
        <?php } ?>
    </form>
</div>
<script>

</script>
</body>
</html>
<?php
if(isset($_POST['submit'])){
    try {
        mailFromFormInput();
    } catch (Exception $e) {
        die($e->getMessage());
    }
}
?>