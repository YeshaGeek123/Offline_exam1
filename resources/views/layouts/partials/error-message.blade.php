@push('scripts')
    @if(Session::has('success'))
        <script type="text/javascript">
            window.toastr.success('{{ Session::pull("success") }}')
        </script>
    @endif

    @if(Session::has('error'))
        <script type="text/javascript">
            window.toastr.error('{{ Session::pull("error") }}')
        </script>
    @endif
@endpush