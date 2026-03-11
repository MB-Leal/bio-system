namespace App\Http\Controllers;

use App\Models\Evaluation;
use Illuminate\Http\Request;

class PublicReportController extends Controller
{
    public function show($hash)
    {
        // Busca a avaliação pelo hash ou falha
        $evaluation = Evaluation::where('hash_slug', $hash)->with('student.evaluations')->firstOrFail();
        
        $student = $evaluation->student;
        
        // Busca a avaliação anterior para calcular a evolução (setinhas)
        $previous = $student->evaluations()
            ->where('evaluation_date', '<', $evaluation->evaluation_date)
            ->orderBy('evaluation_date', 'desc')
            ->first();

        // Dados para o gráfico de evolução (últimas 6 avaliações)
        $history = $student->evaluations()
            ->orderBy('evaluation_date', 'asc')
            ->take(6)
            ->get();

        return view('reports.public', compact('evaluation', 'student', 'previous', 'history'));
    }
}