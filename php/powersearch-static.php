<!-- AGES/GRADES -->
<div id = "powersearch-col-age" class = "powersearch-col">
    <div id = "powersearch-div-age" class = "<?php echo $ageDivClass;?>">
        <select id = "powersearch-age" name = "age" onchange = "powersearchAge()" class = "<?php echo $ageSelectClass;?>">
            <option value = "<?php $ageSelectedValue;?>" selected><?php echo $ageSelectedLabel;?></option>
            <?php
			echo $ageOptionClear;
            foreach($ageRangeOptions as $ageRangeOption)
			{
				$categoryValue 		= $ageRangeOption[0];
				$categoryPlusCount 	= substr_count($categoryValue, '+');
				$categoryValue 		= str_replace('+', ' ', $categoryValue, $categoryPlusCount);
				$categoryName		= $ageRangeOption[2];
				echo '<option value = "'.$categoryValue.'">'.$categoryName.'</option>';
			}
			?>
            <optgroup label = "Grade specific search">    
            <?php
            foreach($gradeLevelOptions as $gradeLevelOption)
			{
				$categoryValue 		= $gradeLevelOption[0];
				$categoryPlusCount 	= substr_count($categoryValue, '+');
				$categoryValue 		= str_replace('+', ' ', $categoryValue, $categoryPlusCount);
				$categoryName		= $gradeLevelOption[2];
				echo '<option value = "'.$categoryValue.'">'.$categoryName.'</option>';
			}
			?>
            </optgroup>   
        </select><!-- /#powersearch-age -->
    </div><!-- /#powersearch-div-age -->
</div><!-- /#powersearch-col-age -->

<!-- PLATFORMS -->
<div id = "powersearch-col-platform" class = "powersearch-col">
    <div id = "powersearch-div-platform" class = "<?php echo $platformDivClass;?>">
        <select id = "powersearch-platform" name = "platform" onchange = "powersearchPlatform()" class = "<?php echo $platformSelectClass;?>">
            <option value = "<?php echo $platformSelectedValue;?>" selected><?php echo $platformSelectedLabel;?></option>
            <?php
			echo $platformOptionClear;
            foreach($platformOptions as $platformOption)
			{
				$categoryValue 		= $platformOption[0];
				$categoryPlusCount 	= substr_count($categoryValue, '+');
				$categoryValue 		= str_replace('+', ' ', $categoryValue, $categoryPlusCount);
				$categoryName		= $platformOption[2];
				echo '<option value = "'.$categoryValue.'">'.$categoryName.'</option>';
			}
			?>
        </select><!-- /#powersearch-platform -->
    </div><!-- /#powersearch-div-platform -->
</div><!-- /#powersearch-col-platform -->

<!-- SUBJECTS -->
<div id = "powersearch-col-subject" class = "powersearch-col">
	<div id = "powersearch-div-subject" class = "<?php echo $subjectDivClass;?>">
        <select id = "powersearch-subject" name = "subject" onchange = "powersearchSubject()" class = "<?php echo $subjectSelectClass;?>">
            <option value = "<?php echo $subjectSelectedValue;?>" selected><?php echo $subjectSelectedLabel;?></option>
            <?php
			echo $subjectOptionClear;
			foreach($subjectOptions as $subjectOption)
			{
				$categoryValue 	= $subjectOption[0];
				$categoryPlusCount 	= substr_count($categoryValue, '+');
				$categoryValue 		= str_replace('+', ' ', $categoryValue, $categoryPlusCount);
				$categoryName	= $subjectOption[2];
				echo '<option value = "'.$categoryValue.'">'.$categoryName.'</option>';
			}
			foreach($subjectOptgroups as $optgroup)
			{
				$optgroupLabel = $optgroup[0];
				$optgroupItems = $optgroup[1];
				echo '<optgroup label = "'.$optgroupLabel.'">';
					foreach($optgroupItems as $optgroupItem)
					{
						echo '<option value = "'.$optgroupItem.'">'.$optgroupItem.'</option>';
					}
				echo '</optgroup>';
			}
			?>
		</select><!-- /#powersearch-subject -->
	</div><!-- /#powersearch-div-subject -->
</div><!-- /#powersearch-col-subject -->

<!-- TOPICS -->
<div id = "powersearch-col-topic" class = "powersearch-col">
	<div id = "powersearch-div-topic" class = "<?php echo $topicDivClass;?>">
        <select id = "powersearch-topic" name = "category" onchange = "powersearchTopic()" class = "<?php echo $topicSelectClass;?>">
            <option value = "<?php echo $topicSelectedValue;?>" selected><?php echo $topicSelectedLabel;?></option>
            <?php
			echo $topicOptionClear;
			foreach($topicOptions as $optgroup)
			{
				$optgroupLabel = $optgroup[0];
				$optgroupItems = $optgroup[1];
				echo '<optgroup label = "'.$optgroupLabel.'">';
					foreach($optgroupItems as $optgroupItem)
					{
						$value = $optgroupItem[0];
						$label = $optgroupItem[1];
						echo '<option value = "'.$value.'">'.$label.'</option>';
					}
				echo '</optgroup>';
			}
            ?>      
        </select><!-- /#powersearch-select-topic -->
    </div><!-- /#powersearch-div-topic -->
</div><!-- /#powersearch-col-topic -->