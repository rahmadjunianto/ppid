<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|in:informasi_umum,permohonan_informasi,pengaduan,saran,lainnya',
            'message' => 'required|string|max:1000',
            'privacy' => 'required|accepted'
        ], [
            'name.required' => 'Nama lengkap wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'subject.required' => 'Subjek wajib dipilih',
            'subject.in' => 'Subjek yang dipilih tidak valid',
            'message.required' => 'Pesan wajib diisi',
            'message.max' => 'Pesan maksimal 1000 karakter',
            'privacy.required' => 'Anda harus menyetujui kebijakan privasi',
            'privacy.accepted' => 'Anda harus menyetujui kebijakan privasi'
        ]);

        try {
            // Prepare email data
            $emailData = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'subject' => $this->getSubjectLabel($request->subject),
                'messageContent' => $request->message,
                'timestamp' => now()->format('d M Y H:i:s')
            ];

            // Send email notification to admin
            Mail::send('emails.contact-form', $emailData, function ($message) use ($request) {
                $message->to(config('mail.admin_email', 'admin@ppid.go.id'))
                        ->subject('Pesan Kontak Baru: ' . $this->getSubjectLabel($request->subject))
                        ->replyTo($request->email, $request->name);
            });

            // Send auto-reply to user
            Mail::send('emails.contact-auto-reply', $emailData, function ($message) use ($request) {
                $message->to($request->email, $request->name)
                        ->subject('Terima kasih atas pesan Anda - PPID');
            });

            // Log the contact form submission
            Log::info('Contact form submitted', [
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'ip' => $request->ip()
            ]);

            return back()->with('success', 'Terima kasih! Pesan Anda telah berhasil dikirim. Kami akan merespons dalam 1-2 hari kerja.');

        } catch (\Exception $e) {
            Log::error('Contact form error: ' . $e->getMessage());
            return back()->with('error', 'Maaf, terjadi kesalahan saat mengirim pesan. Silakan coba lagi atau hubungi kami melalui telepon.');
        }
    }

    private function getSubjectLabel($subject)
    {
        $subjects = [
            'informasi_umum' => 'Informasi Umum',
            'permohonan_informasi' => 'Permohonan Informasi',
            'pengaduan' => 'Pengaduan',
            'saran' => 'Saran & Kritik',
            'lainnya' => 'Lainnya'
        ];

        return $subjects[$subject] ?? 'Tidak Diketahui';
    }
}
