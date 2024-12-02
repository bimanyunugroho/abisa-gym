export function useStatus() {
    const formatStatus = (status) => {
        if (status === true || status === 1 || status === 'true' || status === 'ACTIVE') {
            return {
                icon: '✓',
                text: 'Aktif',
                class: 'text-green-600 dark:text-green-400 dark:bg-dark-default rounded-md px-2 py-1'
            };
        }
        return {
            icon: '✗',
            text: 'Tidak Aktif',
            class: 'text-red-600 dark:text-red-400 dark:bg-dark-default rounded-md px-2 py-1'
        };
    };

    const formatStatusOrientasi = (status) => {
        if (status === true || status === 1 || status === 'true') {
            return {
                icon: '✓',
                text: 'Selesai',
                class: 'text-green-600 dark:text-green-400 dark:bg-dark-default rounded-md px-2 py-1'
            };
        }
        return {
            icon: '✗',
            text: 'Belum Selesai',
            class: 'text-red-600 dark:text-red-400 dark:bg-dark-default rounded-md px-2 py-1'
        };
    };

    return {
        formatStatus,
        formatStatusOrientasi
    };
} 