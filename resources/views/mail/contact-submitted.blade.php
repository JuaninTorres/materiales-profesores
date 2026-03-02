@component('mail::message')
# Nuevo mensaje de contacto

**Nombre:** {{ $data['name'] }}

**Email:** {{ $data['email'] }}

**Asunto:** {{ $data['subject'] ?: '—' }}

**Mensaje:**
> {{ $data['message'] }}

@component('mail::panel')
Enviado desde el formulario de contacto de **profenicolas.cl**.
@endcomponent

@endcomponent
