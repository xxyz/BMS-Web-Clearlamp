<?php
    function get_rank($score, $note) {
        if($score == 0)
            return '';
        if($score >= $note*2)
            return 'MAX';
        elseif($score >= $note*2*0.8889)
            return 'AAA';
        elseif($score >= $note*2*0.7778)
            return 'AA';
        elseif($score>= $note*2*0.6667)
            return 'A';
        elseif($score>= $note*2*0.5556)
            return 'B';
        elseif($score>= $note*2*0.4444)
            return 'C';
        elseif($score>= $note*2*0.3333)
            return 'D';
        elseif($score>= $note*2*0.2222)
            return 'E';
        return F;
    }
    function get_clear($clear_int)
    {
        switch($clear_int) {
            case 0:
                return "NOT-PLAYED";
            case 1:
                return "FAILED";
            case 2:
                return "EASY-CLEAR";
            case 3:
                return "CLEAR";
            case 4:
                return "HARD-CLEAR";
            case 5:
                return "FULL-COMBO";
            default:
                return "?";
        }
    }
    function get_percentage($score, $note) {
        if($note > 0)
            return $score / (2* $note);
        return 0;
    }
    
    function make_table($songdata)
    {
        $table_string = '
            <table id="ScoreTable" class="tablesorter">
                <thead>
                <tr>
                    <th>LV</th>
                    <th>Title</th>
                    <th>Score</th>
                    <th>Clear</th>
                    <th>Rank</th>
                    <th>Rate</th>
                <tr>
                </thead>
                <tbody>
        ';
        foreach($songdata as $song)
        {
            $song_string='';
            $rank = get_rank($song->{"score"}, $song->{"notes"});
            $clear = get_clear($song->{"clear"});
            $percent = get_percentage($song->{"score"}, $song->{"notes"});
            if($song->{"score"} == 0) {
                $song_string = 
                '<tr>
                <td>'.$song->{"level"}.'</td>
                <td>'.$song->{"title"}.'</td>
                <td>'.$song->{"score"}.'</td>
                <td class="'.$clear.'">'.$clear.'</td>
                <td>'.$rank.'</td>
                <td class="graph"></td>
                </tr>';
            }
            else {
                $song_string = 
                '<tr>
                <td>'.$song->{"level"}.'</td>
                <td>'.$song->{"title"}.'</td>
                <td>'.$song->{"score"}.'</td>
                <td class="'.$clear.'">'.$clear.'</td>
                <td>'.$rank.'</td>
                <td class="graph"><div class="graph-bar" style="width: '.($percent*100).'%;">'.round(($percent*100), 2).'%</div></td>
                </tr>';
            }
            $table_string.=$song_string;
        }
        
        $table_string.='</tbody></table>';
        return $table_string;
    }
?>