export function useAge() {
    const calculateAge = (birthDate) => {
        if (!birthDate) return '-';
        
        // Parse tanggal lahir
        const birth = new Date(birthDate);
        
        // Pastikan tanggal valid
        if (isNaN(birth.getTime())) return '-';
        
        // Tanggal hari ini
        const today = new Date();
        
        // Hitung selisih tahun
        let age = today.getFullYear() - birth.getFullYear();
        
        // Koreksi jika belum ulang tahun di tahun ini
        const monthDiff = today.getMonth() - birth.getMonth();
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birth.getDate())) {
            age--;
        }
        
        return `${age} Tahun`;
    };

    return {
        calculateAge
    };
} 