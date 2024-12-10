export function useStatusBayar() {
    const formatStatusBayar = (status) => {
        switch(status) {
            case 'PENDING':
                return {
                    icon: '⏳',
                    text: 'Menunggu',
                    class: 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300 rounded-full px-3 py-1 text-sm font-medium'
                };
            case 'COMPLETED':
                return {
                    icon: '✔️',
                    text: 'Selesai',
                    class: 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300 rounded-full px-3 py-1 text-sm font-medium'
                };
            case 'FAILED':
                return {
                    icon: '❌',
                    text: 'Gagal',
                    class: 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300 rounded-full px-3 py-1 text-sm font-medium'
                };
            case 'REFUNDED':
                return {
                    icon: '💵',
                    text: 'Dikembalikan',
                    class: 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300 rounded-full px-3 py-1 text-sm font-medium'
                };
            default:
                return {
                    icon: '❓',
                    text: 'Lainnya',
                    class: 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300 rounded-full px-3 py-1 text-sm font-medium'
                };
        }
    };

    return {
        formatStatusBayar
    };
}
