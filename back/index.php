

  <!-- nome: -->
                    <div class="form-group">
                        <label>Paciente:</label>
                        <input type="text" name="title" id="" class="form-control" id="title" value="<?php echo !empty($postData['title'])?$postData['title']:''; ?>" require="">
                    </div>
                    
                       <!--calculado time_to  -->
                        <input type="time" name="time_to" id="time_to" class="form-control" value="<?php echo !empty($postData['time_to'])?$postData['time_to']:''; ?>">
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" class="form-control btn-primary" id="submit" value="Adicionar evento">
                    </div>
               
   