@extends('customer.layout')

@section('content')
    <div class="main-content">
        <div class="w-100 d-flex justify-content-between align-items-center mb-3">
            <p class="page-title">Kontak</p>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="padding: 0 0;">
                    <li class="breadcrumb-item"><a href="{{ route('customer.home') }}">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Kontak</li>
                </ol>
            </nav>
        </div>
        <div class="w-100">
            <div class="row">
                <div class="col-6">
                    <p style="color: var(--dark); font-size: 1em; margin-bottom: 1rem; font-weight: 600;">JeeDee Advertising</p>
                    <p style="text-align: justify; font-size: 0.8em; color: var(--dark);">
                        Hubungi Kami Lewat Whatsapp : <a href="https://wa.me/6281227827967?text=Hai, JeeDee Advertising Saya Ingin Bertanya...." target="_blank">+6281227827967</a>
                    </p>
                </div>
                <div class="col-6">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3954.9708240940613!2d110.80701131432397!3d-7.578154676962924!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a16783dbd32eb%3A0xe852ba0aa1842158!2sFakultas%20Ilmu%20Komputer%20-%20Universitas%20Duta%20Bangsa!5e0!3m2!1sid!2sid!4v1655270195966!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>

        </div>
    </div>
@endsection
