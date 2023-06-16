<x-mail::message>
# Um trabalho falhou

Job Class: {{$event->job->resolveName()}}
Job Connection: {{$event->job->getConnectionName()}}
Job Queue: {{$event->job->getQueue()}}
Job Attempts: {{$event->job->attempts()}}


O trabalho com a ID {{$event->job->getJobId()}} falhou com o seguinte erro:

{{$event->exception->getMessage()}}
Job Exception: {{$event->exception->getTraceAsString()}}
Job Data: {{$event->job->getRawBody()}}
Job Payload: {{$event->job->payload()}}


Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
