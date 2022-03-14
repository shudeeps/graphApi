@extends('viewmessage')

@section('content')
    <h1>View Message</h1>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">User Name</th>
            <th scope="col">Message Title Subject</th>
            <th scope="col">Email Address</th>
            <th scope="col">Body</th>
            <th scope="col">Date and Time</th>
            <th scope="col">Please Reply</th>
        </tr>
        </thead>
        @foreach ($eventss as $message)

            <tr>
                <td><?php echo $message->getSender()->getEmailAddress()->getName() ?></td>
                <td><?php echo $message->getSubject() ?></td>
                <td><?php echo $message->getSender()->getEmailAddress()->getAddress() ?></td>
                <td><?php echo $message->getbodypreview() ?></td>


                <td>


                    <form action="{{route('messageSend')}}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" class="form-control" name="eventuser" value={{ $message->getSender()->getEmailAddress()->getName()}} />
                        <input type="hidden" class="form-control" name="eventsubject" value={{$message->getSubject()}} ' />
                        <input type="hidden" class="form-control" name="eventemail" value={{$message->getSender()->getEmailAddress()->getAddress()}} ' />
                        <input type="hidden" class="form-control" name="eventBody" value="{{$message->getbodypreview()}}"/>
                        <button type="submit" class="btn btn-primary">
                            send
                        </button>
                    </form>

            </tr>
            @endforeach
            </table>
    </form>
@endsection