Hello,
<p>Great news! You've received a new contact from your contact form on the Immersion Factory marketing site.</p>

<p><u>Details:</u></p>

<div>
    <ul>
        <li>Name: {{ $contact['name'] }}</li>
        <li>Email: {{ $contact['email'] }}</li>
        <li>Company: {{ $contact['company'] }}</li>
        <li>Subject: {{ $contact['subject'] }}</li>
    </ul>
    <h3>Message</h3>
    <p>{{ $contact['message'] }}</p>
</div>
