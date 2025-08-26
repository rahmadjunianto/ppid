<footer class="main-footer">
    <strong>Copyright &copy; {{ date('Y') }} <a href="{{ url('/') }}" class="text-success">PPID Kemenag Nganjuk</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.0 |
        <b>Total Survey:</b> {{ \App\Models\Survey::count() }} responden
    </div>
</footer>
