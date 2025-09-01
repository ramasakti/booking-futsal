<x-dashboard title="{{ $title }}">
    <button class="btn btn-dark" onclick="sinkronisasi(this)">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="icon icon-tabler icons-tabler-outline icon-tabler-refresh">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" />
            <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" />
        </svg>
        Sinkron
    </button>
    <script>
        const sinkronisasi = async (button) => {
            button.classList.add('btn-loading')
            // const tahun = new Date().getFullYear()
            const tahun = 2024

            try {
                const response = await fetch(`/api/sync?tahun=${tahun}`)
                const data = await response.json()

                if (data) {
                    button.classList.remove('btn-loading')

                    Toastify({
                        text: "Berhasil Sinkronisasi Data!",
                        duration: 3000,
                        position: "center",
                        style: {
                            background: "#0ca678"
                        }
                    }).showToast();
                }
            }
            catch (error) {
                Toastify({
                    text: "Gagal Sinkronisasi Data!",
                    duration: 3000,
                    position: "center",
                    style: {
                        background: "#d63939"
                    }
                }).showToast();
            }
            finally {
                button.classList.remove('btn-loading')
            }
        }
    </script>
</x-dashboard>
