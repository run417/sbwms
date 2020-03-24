measuring service time - when service is status 'ongoing'

on start service
    if there is no 'service time'
        'service start datetime' = current datetime
    if there is 'service time'
        'onhold end datetime' = current datetime
        'onhold time' = 'onhold end datetime' - 'onhold start datetime'

on holding service
    if there is no 'onhold time'
        'onhold start datetime' = current datetime
        'service time' = 'onhold start datetime' - 'service start datetime'
    if there is 'onhold time'
        'service time' = (current datetime - 'onhold end datetime') + 'service time'

on complete

'service end datetime'
'service time' = ('service start datetime' - 'service end datetime') - 'hold time'

on terminate