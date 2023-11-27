<html>
<head>
    <title>CIM- Career IN Motion</title>
</head>
<body>
    <h3>Hello {{ $candidate['first_name'] }}!</h3>
    <p>Please find the Case Study material for your Practiavl Evaluation Test for Job {{ $job->vacant_position }}.</p>
    <p>Please follow the link to submit your Case Study before  {{ \Carbon\Carbon::parse($case_study->submission_date)->format('jS F Y') }}
        ,
        {{ \Carbon\Carbon::parse($case_study->submission_time)->format('g:i A') }} </p>
    <a href="{{ $signedUrl }}">{{ $signedUrl }}</a>
</body>
</html>