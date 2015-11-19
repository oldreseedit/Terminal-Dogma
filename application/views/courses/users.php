 <!-- Piccolo esempio della direttiva ng-show e della compatibilità Angular-CI -->
<div class="col-xs-6 col-xs-offset-3" ng-app ng-init="state = false"> <!-- ng-init è una direttiva che, durante la compilazione, esegue l'espressione ivi contenuta -->
        <h1><?php echo $title ?></h1>
        
        <input ng-click="state = !state" ng-class="{'btn-warning' : !state, 'btn-success' : state}" class="btn btn-default" style="margin-bottom:30px" type="button" value="Mostra la tabella!"></input> <!-- ng-click cambia il valore di verità di "state" -->
        
        <table ng-show="state" class="table table-striped table-bordered table-condensed"> <!-- ng-show mostra l'elemento quando la variabile "state" è true. -->
                <tr>
                        <th>No.</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Indirizzo</th>
                </tr>
                
                <?php $n = 1;?>
                <?php foreach ($users as $user): ?>
                <tr>
                        <td><?php echo $n ?></td>
                        <td><?php echo $user['Username'] ?></td>
                        <td><?php echo $user['Email'] ?></td>
                        <td><?php echo $user['Indirizzo'] ?></td>
                </tr>
                <?php $n++ ?>
                <?php endforeach ?>
        </table>
</div>