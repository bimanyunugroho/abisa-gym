export function useStatusTipeBayar() {
    const formatStatusTipeBayar = (status) => {
        switch(status) {
            case 'MEMBERSHIP':
                return {
                    icon: '🎯',
                    text: 'Membership',
                    class: 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300 rounded-full px-3 py-1 text-sm font-medium'
                };
            case 'WALK_IN':
                return {
                    icon: '🚶',
                    text: 'Walk In',
                    class: 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300 rounded-full px-3 py-1 text-sm font-medium'
                };
            case 'KELAS':
                return {
                    icon: '📚',
                    text: 'Kelas',
                    class: 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 rounded-full px-3 py-1 text-sm font-medium'
                };
            case 'TRAINING':
                return {
                    icon: '💪',
                    text: 'Training',
                    class: 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300 rounded-full px-3 py-1 text-sm font-medium'
                };
            case 'GUEST_VISIT':
                return {
                    icon: '👥',
                    text: 'Guest Visit',
                    class: 'bg-cyan-100 text-cyan-800 dark:bg-cyan-900 dark:text-cyan-300 rounded-full px-3 py-1 text-sm font-medium'
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
        formatStatusTipeBayar
    };
}