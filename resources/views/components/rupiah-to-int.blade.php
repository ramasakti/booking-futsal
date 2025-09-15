<script>
    const parseRupiahToInt = (rupiah) => {
        console.log(rupiah)
        return parseInt(rupiah.toString().replace(/[^0-9]/g, '')) || 0;
    }
</script>