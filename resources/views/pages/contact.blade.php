@extends('layouts.app')

@section('title', $page->meta_title ?: $page->title)
@section('meta_description', $page->meta_description ?: $page->excerpt)
@section('meta_keywords', $page->meta_keywords)

@section('breadcrumb')
    @foreach($page->getBreadcrumbs() as $breadcrumb)
        @if($loop->last)
            <li class="breadcrumb-item active">{{ $breadcrumb['title'] }}</li>
        @else
            <li class="breadcrumb-item">
                <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a>
            </li>
        @endif
    @endforeach
@endsection

@section('content')
<div class="container my-5">
    <!-- Page Header -->
    <div class="row">
        <div class="col-12">
            <div class="page-header text-center mb-5">
                <h1 class="display-4">{{ $page->title }}</h1>
                @if($page->excerpt)
                    <p class="lead text-muted">{{ $page->excerpt }}</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Contact Information -->
    <div class="row mb-5">
        <div class="col-lg-4 mb-4">
            <div class="contact-card text-center p-4 bg-light rounded shadow-sm h-100">
                <i class="fas fa-map-marker-alt fa-3x text-primary mb-3"></i>
                <h5>Alamat Kantor</h5>
                <p class="text-muted">
                    Jl. Raya No. 123<br>
                    Jakarta Pusat 10110<br>
                    DKI Jakarta, Indonesia
                </p>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="contact-card text-center p-4 bg-light rounded shadow-sm h-100">
                <i class="fas fa-phone fa-3x text-success mb-3"></i>
                <h5>Telepon</h5>
                <p class="text-muted">
                    <strong>Kantor:</strong> (021) 1234-5678<br>
                    <strong>Fax:</strong> (021) 1234-5679<br>
                    <strong>Hotline:</strong> 0800-1234-5678
                </p>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="contact-card text-center p-4 bg-light rounded shadow-sm h-100">
                <i class="fas fa-envelope fa-3x text-info mb-3"></i>
                <h5>Email</h5>
                <p class="text-muted">
                    <strong>Umum:</strong> info@ppid.go.id<br>
                    <strong>Pengaduan:</strong> pengaduan@ppid.go.id<br>
                    <strong>Media:</strong> media@ppid.go.id
                </p>
            </div>
        </div>
    </div>

    <!-- Contact Form and Map -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="contact-form">
                <h3 class="mb-4">Kirim Pesan</h3>

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('contact.send') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone">Nomor Telepon</label>
                        <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                               id="phone" name="phone" value="{{ old('phone') }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="subject">Subjek <span class="text-danger">*</span></label>
                        <select class="form-control @error('subject') is-invalid @enderror"
                                id="subject" name="subject" required>
                            <option value="">Pilih Subjek</option>
                            <option value="informasi_umum" {{ old('subject') == 'informasi_umum' ? 'selected' : '' }}>Informasi Umum</option>
                            <option value="permohonan_informasi" {{ old('subject') == 'permohonan_informasi' ? 'selected' : '' }}>Permohonan Informasi</option>
                            <option value="pengaduan" {{ old('subject') == 'pengaduan' ? 'selected' : '' }}>Pengaduan</option>
                            <option value="saran" {{ old('subject') == 'saran' ? 'selected' : '' }}>Saran & Kritik</option>
                            <option value="lainnya" {{ old('subject') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="message">Pesan <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('message') is-invalid @enderror"
                                  id="message" name="message" rows="6" required>{{ old('message') }}</textarea>
                        @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="privacy" name="privacy" required>
                            <label class="form-check-label" for="privacy">
                                Saya setuju dengan <a href="/privacy-policy" target="_blank">Kebijakan Privasi</a> <span class="text-danger">*</span>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-paper-plane"></i> Kirim Pesan
                    </button>
                </form>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="office-info">
                <h3 class="mb-4">Lokasi Kantor</h3>

                <!-- Google Maps Embed -->
                <div class="map-container mb-4">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.521260322283!2d106.8195613!3d-6.1944491!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f5390917b759%3A0x6b45e67356080477!2sMonas!5e0!3m2!1sen!2sid!4v1635123456789!5m2!1sen!2sid"
                            width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>
                </div>

                <!-- Office Hours -->
                <div class="office-hours bg-light p-4 rounded">
                    <h5><i class="fas fa-clock text-primary"></i> Jam Operasional</h5>
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td><strong>Senin - Kamis</strong></td>
                            <td>08:00 - 16:00 WIB</td>
                        </tr>
                        <tr>
                            <td><strong>Jumat</strong></td>
                            <td>08:00 - 16:30 WIB</td>
                        </tr>
                        <tr>
                            <td><strong>Sabtu - Minggu</strong></td>
                            <td class="text-muted">Tutup</td>
                        </tr>
                    </table>

                    <hr>

                    <div class="emergency-contact">
                        <h6><i class="fas fa-exclamation-triangle text-warning"></i> Kontak Darurat</h6>
                        <p class="mb-1"><strong>24/7 Hotline:</strong> 0800-1234-5678</p>
                        <p class="mb-0"><strong>WhatsApp:</strong> +62 812-3456-7890</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Page Content -->
    @if($page->content)
        <div class="row mt-5">
            <div class="col-12">
                <div class="content-section">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    @endif

    <!-- FAQ Section -->
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="mb-4">Pertanyaan yang Sering Diajukan</h3>
            <div class="accordion" id="faqAccordion">
                <div class="card">
                    <div class="card-header" id="faq1">
                        <h2 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse1">
                                Bagaimana cara mengajukan permohonan informasi?
                            </button>
                        </h2>
                    </div>
                    <div id="collapse1" class="collapse show" data-parent="#faqAccordion">
                        <div class="card-body">
                            Anda dapat mengajukan permohonan informasi melalui formulir online di website kami, datang langsung ke kantor, atau mengirim surat resmi ke alamat kantor kami.
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" id="faq2">
                        <h2 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse2">
                                Berapa lama waktu pemrosesan permohonan informasi?
                            </button>
                        </h2>
                    </div>
                    <div id="collapse2" class="collapse" data-parent="#faqAccordion">
                        <div class="card-body">
                            Sesuai dengan UU No. 14 Tahun 2008, waktu pemrosesan adalah maksimal 10 hari kerja untuk informasi yang tersedia dan 17 hari kerja untuk informasi yang tidak tersedia.
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" id="faq3">
                        <h2 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse3">
                                Apakah ada biaya untuk permohonan informasi?
                            </button>
                        </h2>
                    </div>
                    <div id="collapse3" class="collapse" data-parent="#faqAccordion">
                        <div class="card-body">
                            Tidak ada biaya untuk mengajukan permohonan informasi. Namun, pemohon dapat dikenakan biaya penggandaan sesuai dengan tarif yang berlaku.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.contact-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.contact-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important;
}

.contact-card i {
    transition: transform 0.3s ease;
}

.contact-card:hover i {
    transform: scale(1.1);
}

.contact-form {
    background-color: #f8f9fa;
    padding: 2rem;
    border-radius: 0.5rem;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.map-container {
    border-radius: 0.5rem;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.office-hours {
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.content-section {
    font-size: 1.1rem;
    line-height: 1.7;
}

.content-section h1,
.content-section h2,
.content-section h3,
.content-section h4,
.content-section h5,
.content-section h6 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    color: #2c3e50;
}

.accordion .card {
    border: 1px solid #dee2e6;
    margin-bottom: 0.5rem;
}

.accordion .card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.accordion .btn-link {
    color: #2c3e50;
    text-decoration: none;
    font-weight: 500;
}

.accordion .btn-link:hover {
    color: #007bff;
}

.emergency-contact {
    background-color: #fff3cd;
    padding: 1rem;
    border-radius: 0.25rem;
    border-left: 4px solid #ffc107;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .contact-form {
        padding: 1.5rem;
    }

    .page-header .display-4 {
        font-size: 2rem;
    }
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation enhancement
    const form = document.querySelector('form');
    const submitBtn = form.querySelector('button[type="submit"]');

    form.addEventListener('submit', function(e) {
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
        submitBtn.disabled = true;
    });

    // Character counter for message textarea
    const messageTextarea = document.getElementById('message');
    const maxLength = 1000;

    if (messageTextarea) {
        const counter = document.createElement('small');
        counter.className = 'text-muted';
        messageTextarea.parentNode.appendChild(counter);

        function updateCounter() {
            const remaining = maxLength - messageTextarea.value.length;
            counter.textContent = `${messageTextarea.value.length}/${maxLength} karakter`;

            if (remaining < 50) {
                counter.classList.add('text-warning');
                counter.classList.remove('text-muted');
            } else {
                counter.classList.add('text-muted');
                counter.classList.remove('text-warning');
            }
        }

        messageTextarea.addEventListener('input', updateCounter);
        updateCounter();
    }
});
</script>
@endsection
