export function useTanggal() {
    const formatTanggal = (tanggal) => {
        if (!tanggal) return '-';
        
        // Parse tanggal dari format database (YYYY-MM-DD)
        const date = new Date(tanggal);
        
        // Pastikan tanggal valid
        if (isNaN(date.getTime())) return '-';
        
        // Format tanggal ke DD-MM-YYYY
        const day = date.getDate().toString().padStart(2, '0');
        const month = (date.getMonth() + 1).toString().padStart(2, '0');
        const year = date.getFullYear();
        
        return `${day}-${month}-${year}`;
    };

    const formatTanggalWaktu = (tanggal) => {
        if (!tanggal) return '-';
        
        // Parse tanggal dan waktu dari format database (YYYY-MM-DD HH:mm:ss)
        const date = new Date(tanggal);
        
        // Pastikan tanggal valid
        if (isNaN(date.getTime())) return '-';
        
        // Format tanggal ke DD-MM-YYYY HH:mm
        const day = date.getDate().toString().padStart(2, '0');
        const month = (date.getMonth() + 1).toString().padStart(2, '0');
        const year = date.getFullYear();
        const hours = date.getHours().toString().padStart(2, '0');
        const minutes = date.getMinutes().toString().padStart(2, '0');
        
        return `${day}-${month}-${year} ${hours}:${minutes}`;
    };

    const formatWaktu = (tanggal) => {
        if (!tanggal) return '-';
        
        // Parse waktu dari format database
        const date = new Date(tanggal);
        
        // Pastikan tanggal valid
        if (isNaN(date.getTime())) return '-';
        
        // Format waktu ke HH:mm
        const hours = date.getHours().toString().padStart(2, '0');
        const minutes = date.getMinutes().toString().padStart(2, '0');
        
        return `${hours}:${minutes}`;
    };

    return {
        formatTanggal,
        formatTanggalWaktu,
        formatWaktu
    };
}
