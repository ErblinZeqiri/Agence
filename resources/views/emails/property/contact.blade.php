<x-mail::message>
# Nouvelle demande de contact

Une nouvelle demande de contact a été fait pour le bien : <br>
<a href="{{ route('property.show', ['slug' => $property->getSlug(),
'property' => $property])}}">{{ $property->title }}.</a>

- Prénom : {{ $data['firstname'] }}
- Nom : {{ $data['name'] }}
- Téléphone : {{ $data['phone'] }}
- Email : {{ $data['email'] }}

<strong>Message : </strong><br>
{{ $data['message'] }}

</x-mail::message>
