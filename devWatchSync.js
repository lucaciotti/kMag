module.exports = {
    'source': '/c/PROJECTS/kMag2',
    'target': '/var/www/html/kMag2/',
    'user': 'ced',
    'host': '172.16.9.39',
    'excludes': [
        '.git', // for faster syncing
        'assets',
        'wip',
        'rSync',
        'esp',
        'dist',
        'logs',
        'node_modules',
    ]
}