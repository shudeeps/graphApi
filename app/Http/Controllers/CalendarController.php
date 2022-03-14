<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use App\TokenStore\TokenCache;
use App\TimeZones\TimeZones;

class CalendarController extends Controller
{

    public function amritmail()
    {

        $tokenCache = new TokenCache();

        $accessToken = $tokenCache->getAccessToken();

        //dd($accessToken);
        $accessToken = 'eyJ0eXAiOiJKV1QiLCJub25jZSI6ImMwUUhyeXozOTZrcGhhZ2dxelRPdFNsRjBUYm9fUld5NnR6UVRMeko3XzQiLCJhbGciOiJSUzI1NiIsIng1dCI6ImpTMVhvMU9XRGpfNTJ2YndHTmd2UU8yVnpNYyIsImtpZCI6ImpTMVhvMU9XRGpfNTJ2YndHTmd2UU8yVnpNYyJ9.eyJhdWQiOiIwMDAwMDAwMy0wMDAwLTAwMDAtYzAwMC0wMDAwMDAwMDAwMDAiLCJpc3MiOiJodHRwczovL3N0cy53aW5kb3dzLm5ldC8yYzVjMDBlMy05ODA1LTQwMDktYjg2Yy1mOGZmZWVmNmM0YjUvIiwiaWF0IjoxNjQ3MjEyMTEwLCJuYmYiOjE2NDcyMTIxMTAsImV4cCI6MTY0NzIxNjU4NiwiYWNjdCI6MCwiYWNyIjoiMSIsImFpbyI6IkUyWmdZQWpWUDk4WVBUVnEwdmZIRFk0SDFwU3VpbXJWNE9kZFhWcFFNdXY4dWZoY2d3NEEiLCJhbXIiOlsicHdkIl0sImFwcF9kaXNwbGF5bmFtZSI6IkdyYXBoIEV4cGxvcmVyIiwiYXBwaWQiOiJkZThiYzhiNS1kOWY5LTQ4YjEtYThhZC1iNzQ4ZGE3MjUwNjQiLCJhcHBpZGFjciI6IjAiLCJmYW1pbHlfbmFtZSI6Ikd1cnVuZyIsImdpdmVuX25hbWUiOiJBbXJpdCIsImlkdHlwIjoidXNlciIsImlwYWRkciI6IjYyLjMwLjE5OS4yMzMiLCJuYW1lIjoiQW1yaXQgR3VydW5nIiwib2lkIjoiNjAzYzA0MGQtZmEzOC00MTU4LTg4NjgtYWJhMWQ4NzkyNTNhIiwicGxhdGYiOiI4IiwicHVpZCI6IjEwMDMyMDAxREZCMjBFODIiLCJyaCI6IjAuQVhNQTR3QmNMQVdZQ1VDNGJQal83dmJFdFFNQUFBQUFBQUFBd0FBQUFBQUFBQUJ6QUJRLiIsInNjcCI6IkNoYW5uZWxNZXNzYWdlLlNlbmQgQ2hhdC5SZWFkV3JpdGUgQ2hhdE1lc3NhZ2UuU2VuZCBGaWxlcy5SZWFkIEZpbGVzLlJlYWQuQWxsIEZpbGVzLlJlYWRXcml0ZSBGaWxlcy5SZWFkV3JpdGUuQWxsIE1haWwuUmVhZCBNYWlsLlJlYWRCYXNpYyBNYWlsLlJlYWRXcml0ZSBNYWlsYm94U2V0dGluZ3MuUmVhZCBvcGVuaWQgcHJvZmlsZSBTaXRlcy5SZWFkLkFsbCBTaXRlcy5SZWFkV3JpdGUuQWxsIFVzZXIuUmVhZCBVc2VyLlJlYWRXcml0ZSBlbWFpbCIsInNpZ25pbl9zdGF0ZSI6WyJrbXNpIl0sInN1YiI6InUzTEVmcko1VnpoSlhtSUpRaDEzYzdIOG9kR2VocUhqTlFpX0NRblN0Qm8iLCJ0ZW5hbnRfcmVnaW9uX3Njb3BlIjoiRVUiLCJ0aWQiOiIyYzVjMDBlMy05ODA1LTQwMDktYjg2Yy1mOGZmZWVmNmM0YjUiLCJ1bmlxdWVfbmFtZSI6ImFtcml0Lmd1cnVuZ0Byb3VuZGNvcnAuY29tIiwidXBuIjoiYW1yaXQuZ3VydW5nQHJvdW5kY29ycC5jb20iLCJ1dGkiOiJVMWRoS0ZoNF9reTJqZHViRk9HSkFBIiwidmVyIjoiMS4wIiwid2lkcyI6WyJiNzlmYmY0ZC0zZWY5LTQ2ODktODE0My03NmIxOTRlODU1MDkiXSwieG1zX3N0Ijp7InN1YiI6IjhQcS1lNTlLVjR0YUhmQkFCWWRfMHFJSnVXOTZkTWlQQUd1dnFyUmdXSjQifSwieG1zX3RjZHQiOjE1OTgyMjAyMDR9.Bi2b9VT-D8QsK5abh_BIygU9lstIrcbeTKOL2qTqf6VXG48OVS1EoIV5vI2zPLLOOVEC_OmEDxMVGMo5T8QQr2BZi44d51E6nFzgsZ-rKSIKdigYRX9QLgUE5gisur_vSPnfsi4iS5SF1V1-gFjkvREUXzawrR3nSY0eyl3_y_kOzgmWfk0PkHmn-LnpA91WvXXG1vfZuCkcLY4bqP5A6L93wAi_XtN-d-W8e41D1S1qXxtyWHVSoSZKhkSxIFx7_KWxjan9of8xZ75Cczhu58oq0vrqtJTTtF6DWyVw4qg16V6vxHHKgedSnKoE2ZjnazxgZuz8U3tSsJ4F_c1ctQ';
        // Create a Graph client
        $graph = new Graph();
        $graph->setAccessToken($accessToken);

        $ptr = $graph->createCollectionRequest("GET", "/me/messages")
            ->setReturnType(Model\Message::class)
            ->setPageSize(10);



        $eventss = $ptr->getPage();

        //dd($eventss);

        //return response()->json($events);

        //  return view('messageView', $events);

        return view('email', compact('eventss'));
    }

    public function getNewEventForm()
    {
        $viewData = $this->loadViewData();

        return view('newevent', $viewData);
    }

    public function reply()
    {
        $viewData = $this->loadViewData();

        return view('replymail', $viewData);
    }

    public function calendar()
    {
        $viewData = $this->loadViewData();

        $graph = $this->getGraph();

        // Get user's timezone
        $timezone = TimeZones::getTzFromWindows($viewData['userTimeZone']);

        // Get start and end of week
        $startOfWeek = new \DateTimeImmutable('sunday -1 week', $timezone);
        $endOfWeek = new \DateTimeImmutable('sunday', $timezone);

        $viewData['dateRange'] = $startOfWeek->format('M j, Y') . ' - ' . $endOfWeek->format('M j, Y');

        $queryParams = array(
            'startDateTime' => $startOfWeek->format(\DateTimeInterface::ISO8601),
            'endDateTime' => $endOfWeek->format(\DateTimeInterface::ISO8601),
            // Only request the properties used by the app
            '$select' => 'subject,organizer,start,end',
            // Sort them by start time
            '$orderby' => 'start/dateTime',
            // Limit results to 25
            '$top' => 25
        );

        // Append query parameters to the '/me/calendarView' url
        $getEventsUrl = '/me/calendarView?' . http_build_query($queryParams);

        $events = $graph->createRequest('GET', $getEventsUrl)
            // Add the user's timezone to the Prefer header
            ->addHeaders(array(
                'Prefer' => 'outlook.timezone="' . $viewData['userTimeZone'] . '"'
            ))
            ->setReturnType(Model\Event::class)
            ->execute();
        dd($events);
        $viewData['events'] = $events;
        return view('calendar', $viewData);
    }
    /*
  public function calendars()
  {
    $tokenCache = new TokenCache();
    $accessToken = 'eyJ0eXAiOiJKV1QiLCJub25jZSI6Ik9tcDNCVE0tNzRHODR0OTFNYmk2a2NZNWRfRnBpN2J6Q3QyMUtHX201UWciLCJhbGciOiJSUzI1NiIsIng1dCI6ImpTMVhvMU9XRGpfNTJ2YndHTmd2UU8yVnpNYyIsImtpZCI6ImpTMVhvMU9XRGpfNTJ2YndHTmd2UU8yVnpNYyJ9.eyJhdWQiOiIwMDAwMDAwMy0wMDAwLTAwMDAtYzAwMC0wMDAwMDAwMDAwMDAiLCJpc3MiOiJodHRwczovL3N0cy53aW5kb3dzLm5ldC8yYzVjMDBlMy05ODA1LTQwMDktYjg2Yy1mOGZmZWVmNmM0YjUvIiwiaWF0IjoxNjQ2NjgxMjIzLCJuYmYiOjE2NDY2ODEyMjMsImV4cCI6MTY0NjY4NTM3MywiYWNjdCI6MCwiYWNyIjoiMSIsImFpbyI6IkFTUUEyLzhUQUFBQUZaWE5LOFRwbDJKK24xWnJlRW9ZdHAzOFEvWVR1b3kxYnZOU3ZtOHNGOWM9IiwiYW1yIjpbInB3ZCJdLCJhcHBfZGlzcGxheW5hbWUiOiJHcmFwaCBFeHBsb3JlciIsImFwcGlkIjoiZGU4YmM4YjUtZDlmOS00OGIxLWE4YWQtYjc0OGRhNzI1MDY0IiwiYXBwaWRhY3IiOiIwIiwiZmFtaWx5X25hbWUiOiJHdXJ1bmciLCJnaXZlbl9uYW1lIjoiQW1yaXQiLCJpZHR5cCI6InVzZXIiLCJpcGFkZHIiOiI2Mi4zMC4xOTkuMjMzIiwibmFtZSI6IkFtcml0IEd1cnVuZyIsIm9pZCI6IjYwM2MwNDBkLWZhMzgtNDE1OC04ODY4LWFiYTFkODc5MjUzYSIsInBsYXRmIjoiOCIsInB1aWQiOiIxMDAzMjAwMURGQjIwRTgyIiwicmgiOiIwLkFYTUE0d0JjTEFXWUNVQzRiUGpfN3ZiRXRRTUFBQUFBQUFBQXdBQUFBQUFBQUFCekFCUS4iLCJzY3AiOiJGaWxlcy5SZWFkIEZpbGVzLlJlYWQuQWxsIEZpbGVzLlJlYWRXcml0ZSBGaWxlcy5SZWFkV3JpdGUuQWxsIE1haWwuUmVhZCBNYWlsLlJlYWRCYXNpYyBNYWlsLlJlYWRXcml0ZSBNYWlsYm94U2V0dGluZ3MuUmVhZCBvcGVuaWQgcHJvZmlsZSBTaXRlcy5SZWFkLkFsbCBTaXRlcy5SZWFkV3JpdGUuQWxsIFVzZXIuUmVhZCBVc2VyLlJlYWRXcml0ZSBlbWFpbCIsInNpZ25pbl9zdGF0ZSI6WyJrbXNpIl0sInN1YiI6InUzTEVmcko1VnpoSlhtSUpRaDEzYzdIOG9kR2VocUhqTlFpX0NRblN0Qm8iLCJ0ZW5hbnRfcmVnaW9uX3Njb3BlIjoiRVUiLCJ0aWQiOiIyYzVjMDBlMy05ODA1LTQwMDktYjg2Yy1mOGZmZWVmNmM0YjUiLCJ1bmlxdWVfbmFtZSI6ImFtcml0Lmd1cnVuZ0Byb3VuZGNvcnAuY29tIiwidXBuIjoiYW1yaXQuZ3VydW5nQHJvdW5kY29ycC5jb20iLCJ1dGkiOiJ2ZXRBUFJaTFRrR3BLVERDZTZBc0FBIiwidmVyIjoiMS4wIiwid2lkcyI6WyJiNzlmYmY0ZC0zZWY5LTQ2ODktODE0My03NmIxOTRlODU1MDkiXSwieG1zX3N0Ijp7InN1YiI6IjhQcS1lNTlLVjR0YUhmQkFCWWRfMHFJSnVXOTZkTWlQQUd1dnFyUmdXSjQifSwieG1zX3RjZHQiOjE1OTgyMjAyMDR9.k6CqP6mFa8t2PZ5RNYhjfAu3AdY8tbh2Fz6_YwPBZr2VL1BCs3qBJgRLETfOWVJsTxydrdsw11O5Y3xop8WmQknrJdJIxRas-MlFi4Vhw4pKVTNtmBbWamcg9MxuLFAsXeATD2T9dgl4nrABipQmotFXAxiMzKwB5Cebv_eLtVykWb3w2AEQmcYKAaULV6YHboqbfAH9qDpOI7OinH_WUumKDqlAlkwWjszieZgZULQoE1-iLfLsA98Id1qQPTkfdRORR4c57XS9DLlgBxZK1PMuo41025MBbo5Yk9PaKKa9I9auwOeaNGi0mGX_syrjChSF_dZbqlJCj-uXZLxtJQ';
  //  dd($accessToken);

    // Create a Graph client
    $graph = new Graph();
    $graph->setAccessToken($accessToken);

    $ptr=$graph->createCollectionRequest("GET","/me/messages")
                ->setReturnType(Model\Message::class)
                ->setPageSize(10);



       $msgs=$ptr->getPage();

       dd($msgs);

     return response()->json($msgs);
  }
*/

    private function getGraph(): Graph
    {
        // Get the access token from the cache
        $tokenCache = new TokenCache();
        $accessToken = $tokenCache->getAccessToken();

        // Create a Graph client
        $graph = new Graph();
        $graph->setAccessToken($accessToken);
        return $graph;
    }

    public function createNewEvent(Request $request)
    {
        // Validate required fields
        $request->validate([
            'eventSubject' => 'nullable|string',
            'eventAttendees' => 'nullable|string',
            'eventStart' => 'required|date',
            'eventEnd' => 'required|date',
            'eventBody' => 'nullable|string'
        ]);

        $viewData = $this->loadViewData();

        $graph = $this->getGraph();

        // Attendees from form are a semi-colon delimited list of
        // email addresses
        $attendeeAddresses = explode(';', $request->eventAttendees);

        // The Attendee object in Graph is complex, so build the structure
        $attendees = [];
        foreach ($attendeeAddresses as $attendeeAddress) {
            array_push($attendees, [
                // Add the email address in the emailAddress property
                'emailAddress' => [
                    'address' => $attendeeAddress
                ],
                // Set the attendee type to required
                'type' => 'required'
            ]);
        }

        // Build the event
        $newEvent = [
            'subject' => $request->eventSubject,
            'attendees' => $attendees,
            'start' => [
                'dateTime' => $request->eventStart,
                'timeZone' => $viewData['userTimeZone']
            ],
            'end' => [
                'dateTime' => $request->eventEnd,
                'timeZone' => $viewData['userTimeZone']
            ],
            'body' => [
                'content' => $request->eventBody,
                'contentType' => 'text'
            ]
        ];
        dd($newEvent);
        // POST /me/events
        $response = $graph->createRequest('POST', '/me/events')
            ->attachBody($newEvent)
            ->setReturnType(Model\Event::class)
            ->execute();

        return redirect('/calendar');
    }


















    public function pleasereply(Request $request)
    {

        // Validate required fields
        $request->validate([
            'eventuser' => 'nullable|string',
            'eventemail' => 'nullable|string',
            'eventsubject' => 'nullable|string',
            'eventBody' => 'nullable|string'
            //  'eventdate' => 'nullable|string'
        ]);

        
        $randomNumber= rand(500, 15000000);
  
        $body='We have received your email.You support ticket number is '.$randomNumber.'. We will get in touch with you soon. ';
      
        $tokenCache = new TokenCache();

        $accessToken = $tokenCache->getAccessToken();

        //dd($accessToken);
        $accessToken = 'eyJ0eXAiOiJKV1QiLCJub25jZSI6ImdFazhKU3dKMldCMFc2cEVwU2dzSVd2bDVoa2RqYlZCbDhCNWx0Y1BGaEUiLCJhbGciOiJSUzI1NiIsIng1dCI6ImpTMVhvMU9XRGpfNTJ2YndHTmd2UU8yVnpNYyIsImtpZCI6ImpTMVhvMU9XRGpfNTJ2YndHTmd2UU8yVnpNYyJ9.eyJhdWQiOiIwMDAwMDAwMy0wMDAwLTAwMDAtYzAwMC0wMDAwMDAwMDAwMDAiLCJpc3MiOiJodHRwczovL3N0cy53aW5kb3dzLm5ldC8yYzVjMDBlMy05ODA1LTQwMDktYjg2Yy1mOGZmZWVmNmM0YjUvIiwiaWF0IjoxNjQ3MjEyNDExLCJuYmYiOjE2NDcyMTI0MTEsImV4cCI6MTY0NzIxNjQwNywiYWNjdCI6MCwiYWNyIjoiMSIsImFpbyI6IkUyWmdZRWkvZE94MFdQU0N6RC96V0RYVjE1c0VGc3lTVlE0VDBaZlF0RDAvcTBQVGVUSUEiLCJhbXIiOlsicHdkIl0sImFwcF9kaXNwbGF5bmFtZSI6IkdyYXBoIEV4cGxvcmVyIiwiYXBwaWQiOiJkZThiYzhiNS1kOWY5LTQ4YjEtYThhZC1iNzQ4ZGE3MjUwNjQiLCJhcHBpZGFjciI6IjAiLCJmYW1pbHlfbmFtZSI6Ikd1cnVuZyIsImdpdmVuX25hbWUiOiJBbXJpdCIsImlkdHlwIjoidXNlciIsImlwYWRkciI6IjYyLjMwLjE5OS4yMzMiLCJuYW1lIjoiQW1yaXQgR3VydW5nIiwib2lkIjoiNjAzYzA0MGQtZmEzOC00MTU4LTg4NjgtYWJhMWQ4NzkyNTNhIiwicGxhdGYiOiI4IiwicHVpZCI6IjEwMDMyMDAxREZCMjBFODIiLCJyaCI6IjAuQVhNQTR3QmNMQVdZQ1VDNGJQal83dmJFdFFNQUFBQUFBQUFBd0FBQUFBQUFBQUJ6QUJRLiIsInNjcCI6IkNoYW5uZWxNZXNzYWdlLlNlbmQgQ2hhdC5SZWFkV3JpdGUgQ2hhdE1lc3NhZ2UuU2VuZCBGaWxlcy5SZWFkIEZpbGVzLlJlYWQuQWxsIEZpbGVzLlJlYWRXcml0ZSBGaWxlcy5SZWFkV3JpdGUuQWxsIE1haWwuUmVhZCBNYWlsLlJlYWRCYXNpYyBNYWlsLlJlYWRXcml0ZSBNYWlsYm94U2V0dGluZ3MuUmVhZCBvcGVuaWQgcHJvZmlsZSBTaXRlcy5SZWFkLkFsbCBTaXRlcy5SZWFkV3JpdGUuQWxsIFVzZXIuUmVhZCBVc2VyLlJlYWRXcml0ZSBlbWFpbCBNYWlsLlNlbmQiLCJzaWduaW5fc3RhdGUiOlsia21zaSJdLCJzdWIiOiJ1M0xFZnJKNVZ6aEpYbUlKUWgxM2M3SDhvZEdlaHFIak5RaV9DUW5TdEJvIiwidGVuYW50X3JlZ2lvbl9zY29wZSI6IkVVIiwidGlkIjoiMmM1YzAwZTMtOTgwNS00MDA5LWI4NmMtZjhmZmVlZjZjNGI1IiwidW5pcXVlX25hbWUiOiJhbXJpdC5ndXJ1bmdAcm91bmRjb3JwLmNvbSIsInVwbiI6ImFtcml0Lmd1cnVuZ0Byb3VuZGNvcnAuY29tIiwidXRpIjoiODZzM2lEMGw1VW1xVFl3QlI1T0xBQSIsInZlciI6IjEuMCIsIndpZHMiOlsiYjc5ZmJmNGQtM2VmOS00Njg5LTgxNDMtNzZiMTk0ZTg1NTA5Il0sInhtc19zdCI6eyJzdWIiOiI4UHEtZTU5S1Y0dGFIZkJBQllkXzBxSUp1Vzk2ZE1pUEFHdXZxclJnV0o0In0sInhtc190Y2R0IjoxNTk4MjIwMjA0fQ.CrURhJiMEKA-ZZ6XpBMRYVYucxr-a172KtRb7RMQ54gY22twn3b5XV4OTdOj4p57--FDe42Z-m-DJshpIOqbctO0O1OII8uAJg1LfeQQRu-SOiLJOPlH-DcMIrbbc_xf6qPEz1Vj_eYveqcpMXyaf2macBYKJV4Fmm630XGqbi7GeLq4t-EoTWg7MVQ54ye6XFCnRIS2Eam88xJ_bX7DMD2hIxge2lXSdN6iQ8mbvpftVf7j0oVyZrDNMWZYA8cVAIj_hPlrfdhlEfDk-MFTtLu6O0h-Zy6L3ODo5qOAnyLUSe5hugYpG9SoiChJpL0fBzEBaGoreZU50QjKR4frKw';   // Create a Graph client
        $graph = new Graph();
        $graph->setAccessToken($accessToken);
        // dd($request);
        $viewData = $this->loadViewData();



        // Attendees from form are a semi-colon delimited list of
        // email addresses
        $gomessage = explode(';', $request->eventMail);


        // Build the event

        $mailBody = array(
            "Message" => array(
                "subject" => "Test Email",
                "body" => array(
                    "contentType" => "html",
                    "content" => $body,
                ),
                "sender" => array(
                    "emailAddress" => array(
                        "name" => $request->eventuser,
                        "address" => 'amrit.gurung@roundcorp.com',
                    )
                ),
                "from" => array(
                    "emailAddress" => array(
                        "name" => $request->eventuser,
                        "address" => 'amrit.gurung@roundcorp.com',
                    )
                ),
                "toRecipients" => array(
                    array(
                        "emailAddress" => array(
                            "name" => $request->eventuser,
                            "address" => $request->eventemail,

                        )
                    )
                )
            )
        );


        //  dd($sendMail);

        // POST /me/events
        $response = $graph->createRequest('POST', '/me/sendMail')
            ->attachBody($mailBody)
            ->execute();


        dd($response);
        return redirect('/messageA');
    }
}
