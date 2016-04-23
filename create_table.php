<?php
    function make_sum_table ($mode, $all_level_count, $rank_count){
        return "
        <table id='count_table'>
            <thead>
                <tr class='count_table_head'>
                    <th>FC</th>
                    <th>HARD</th>
                    <th>GROOVE</th>
                    <th>EASY</th>
                    <th>FAILED</th>
                    <th>NotPlayed</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class='FC'>".(int)$all_level_count[5]."</td>
                    <td class='HARD'>".(int)$all_level_count[4]."</td>
                    <td class='GROOVE'>".(int)$all_level_count[3]."</td>
                    <td class='EASY'>".(int)$all_level_count[2]."</td>
                    <td class='FAIL'>".(int)$all_level_count[1]."</td>
                    <td class='NOPLAY'>".(int)$all_level_count[0]."</td>
            </tbody>
        </table>
        
        <table id='count_table'>
            <thead>
                <tr class='count_table_head'>
                    <th>MAX</th>
                    <th>AAA</th>
                    <th>AA</th>
                    <th>A</th>
                    <th>B</th>
                    <th>C~F</th>
                    <th>NotPlayed</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class='MAX'>".(int)($rank_count[6])."</td>
                    <td class='AAA'>".(int)$rank_count[5]."</td>
                    <td class='AA'>".(int)$rank_count[4]."</td>
                    <td class='A'>".(int)$rank_count[3]."</td>
                    <td class='B'>".(int)$rank_count[2]."</td>
                    <td class='CF'>".(int)$rank_count[1]."</td>
                    <td class='NOPLAY'>".(int)$rank_count[0]."</td>
            </tbody>
        </table>";
    }
    function get_rank_int($score, $note) {
        if($score == 0)
            return 0;
        if($score >= $note*2)
            return 6;
        elseif($score >= $note*2*0.8889)
            return 5;
        elseif($score >= $note*2*0.7778)
            return 4;
        elseif($score>= $note*2*0.6667)
            return 3;
        elseif($score>= $note*2*0.5556)
            return 2;
        elseif($score>= $note*2*0.4444)
            return 1;
        elseif($score>= $note*2*0.3333)
            return 1;
        elseif($score>= $note*2*0.2222)
            return 1;
        return 0;
    }
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
    
    function make_table($songdata, &$clear_counter, &$rank_counter)
    {
        $table_string = '
            <table id="ScoreTable" class="tablesorter">
                <thead>
                <tr>
                    <th class="th-LV">LV</th>
                    <th class="th-title">Title</th>
                    <th class="th-score">Score</th>
                    <th class="th-clear">Clear</th>
                    <th class="th-rank">Rank</th>
                    <th class="th-rate">Rate</th>
                <tr>
                </thead>
                <tbody>
        ';
        foreach($songdata as $song)
        {
            $clear_counter[(int)$song->{"clear"}]++;
            $song_string='';
            $rank_counter[get_rank_int($song->{"score"}, $song->{"notes"})]++;
            $rank = get_rank($song->{"score"}, $song->{"notes"});
            $clear = get_clear($song->{"clear"});
            $percent = get_percentage($song->{"score"}, $song->{"notes"});
            $song_string = 
                '<tr>
                <td>'.$song->{"level"}.'</td>
                <td class="td-title td-title-'.$clear.'"><a target="_blank" href="http://www.dream-pro.info/~lavalse/LR2IR/search.cgi?mode=ranking&bmsmd5='.$song->{"md5"}.'">'.$song->{"title"}.'</td>
                <td>'.$song->{"score"}.'</td>
                <td class="td-clear '.$clear.'"><span class="not-show">'.$clear.'</span></td>
                <td class="td-rank td-'.$rank.'"><span class="not-show">'.$rank.'</span></td>';
            if($song->{"score"} == 0) {
                $song_string.=
                '<td class="graph"></td>
                </tr>';
            }else {
                $song_string.=
                '<td class="graph"><div class="graph-bar" style="width: '.($percent*100).'%;">'.round(($percent*100), 2).'%</div></td>
                </tr>';
            }
            $table_string.=$song_string;
        }
        
        $table_string.='</tbody></table>';
        return $table_string;
    }
?>